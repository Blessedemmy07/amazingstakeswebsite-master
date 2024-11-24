# Use the official PHP with Apache base image
FROM php:8.1-apache

# Install necessary system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    g++

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install -j$(nproc) \
    bz2 \
    intl \
    iconv \
    bcmath \
    opcache \
    calendar \
    pdo_mysql \
    mysqli \
    gd

# Install Composer (Dependency Manager for PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Apache configuration
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite headers

# Allow .htaccess overrides for public and public/blog directories
RUN echo "<Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>" >> /etc/apache2/apache2.conf
RUN echo "<Directory /var/www/html/public/news>\n    AllowOverride All\n    Require all granted\n</Directory>" >> /etc/apache2/apache2.conf

# Update Apache to listen on port 5000
RUN sed -i 's/Listen 80/Listen 5000/' /etc/apache2/ports.conf
RUN sed -i 's/:80/:5000/' /etc/apache2/sites-available/*.conf

# Add ServerName directive to Apache configuration
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Ensure PHP logs are captured by the container
ENV LOG_CHANNEL=stderr

# Set a volume mount point for your code
VOLUME /var/www/html

# Copy your PHP code into the container
COPY . /var/www/html

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Run Composer to install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set the correct permissions for the public folder to avoid permission denied errors
# RUN chown -R www-data:www-data /var/www/html/public \
#     && chmod -R 775 /var/www/html/public
# Set the correct permissions for the public and public/news folders
RUN chown -R www-data:www-data /var/www/html/public \
    && chmod -R 775 /var/www/html/public \
    && chown -R www-data:www-data /var/www/html/public/news \
    && chmod -R 775 /var/www/html/public/news

# Expose port 5000 for Apache
EXPOSE 5000

# Start Apache in the foreground (entrypoint)
CMD ["apache2-foreground"]