<?php
include __DIR__ . "/../../components/auth-includes/session.inc.php";
include __DIR__ . "/../../components/auth-includes/header.inc.php";
include_once __DIR__ . "/../../components/includes/header.inc.php";
include_once __DIR__ . "/../../components/includes/navbar.inc.php";
?>

<div class="content-wrapper">
    <div class="container flex-grow-1 container-p-y">
        <div class="row" style="margin:15px">
            <div class="card p-3">
                <h2 class="text-center mb-2">SELECT YOUR COUNTRY</h2>
                <form method="post" class="text-center">
                    <div class="form-group">
                        <div class="col-md-6 col-lg-6 mx-auto" style="padding: 20px;">
                            <select id="countrySelect" class="form-control" onchange="window.location.href=this.value;">
                                <option>**Select your country**</option>
                                <option value="choose-inter">Afghanistan</option>
                                <option value="choose-inter">Albania</option>
                                <option value="choose-inter">Algeria</option>
                                <option value="choose-inter">American Samoa</option>
                                <option value="choose-inter">Andorra</option>
                                <option value="choose-inter">Angola</option>
                                <option value="choose-inter">Anguilla</option>
                                <option value="choose-inter">Antarctica</option>
                                <option value="choose-inter">Antigua and Barbuda</option>
                                <option value="choose-inter">Argentina</option>
                                <option value="choose-inter">Armenia</option>
                                <option value="choose-inter">Aruba</option>
                                <option value="choose-inter">Australia</option>
                                <option value="choose-inter">Austria</option>
                                <option value="choose-inter">Azerbaijan</option>
                                <option value="choose-inter">Bahrain</option>
                                <option value="choose-inter">Bangladesh</option>
                                <option value="choose-inter">Barbados</option>
                                <option value="choose-inter">Belarus</option>
                                <option value="choose-inter">Belgium</option>
                                <option value="choose-inter">Belize</option>
                                <option value="choose-inter">Benin</option>
                                <option value="choose-inter">Bermuda</option>
                                <option value="choose-inter">Bhutan</option>
                                <option value="choose-inter">Bolivia</option>
                                <option value="choose-inter">Bosnia and Herzegovina</option>
                                <option value="choose-inter">Botswana</option>
                                <option value="choose-inter">Bouvet Island</option>
                                <option value="choose-inter">Brazil</option>
                                <option value="choose-inter">British Indian Ocean Territory</option>
                                <option value="choose-inter">British Virgin Islands</option>
                                <option value="choose-inter">Brunei</option>
                                <option value="choose-inter">Bulgaria</option>
                                <option value="choose-inter">Burkina Faso</option>
                                <option value="choose-inter">Burundi</option>
                                <option value="choose-inter">Côte d'Ivoire</option>
                                <option value="choose-inter">Cambodia</option>
                                <option value="cameroon-payment">Cameroon</option>
                                <option value="choose-inter">Canada</option>
                                <option value="choose-inter">Cape Verde</option>
                                <option value="choose-inter">Cayman Islands</option>
                                <option value="choose-inter">Central African Republic</option>
                                <option value="choose-inter">Chad</option>
                                <option value="choose-inter">Chile</option>
                                <option value="choose-inter">China</option>
                                <option value="choose-inter">Christmas Island</option>
                                <option value="choose-inter">Cocos (Keeling) Islands</option>
                                <option value="choose-inter">Colombia</option>
                                <option value="choose-inter">Comoros</option>
                                <option value="choose-inter">Congo</option>
                                <option value="choose-inter">Cook Islands</option>
                                <option value="choose-inter">Costa Rica</option>
                                <option value="choose-inter">Croatia</option>
                                <option value="choose-inter">Cuba</option>
                                <option value="choose-inter">Cyprus</option>
                                <option value="choose-inter">Czech Republic</option>
                                <option value="choose-inter">Democratic Republic of the Congo</option>
                                <option value="choose-inter">Denmark</option>
                                <option value="choose-inter">Djibouti</option>
                                <option value="choose-inter">Dominica</option>
                                <option value="choose-inter">Dominican Republic</option>
                                <option value="choose-inter">East Timor</option>
                                <option value="choose-inter">Ecuador</option>
                                <option value="choose-inter">Egypt</option>
                                <option value="choose-inter">El Salvador</option>
                                <option value="choose-uk">England</option>
                                <option value="choose-inter">Equatorial Guinea</option>
                                <option value="choose-inter">Eritrea</option>
                                <option value="choose-inter">Estonia</option>
                                <option value="choose-inter">Ethiopia</option>
                                <option value="choose-inter">Faeroe Islands</option>
                                <option value="choose-inter">Falkland Islands</option>
                                <option value="choose-inter">Fiji</option>
                                <option value="choose-inter">Finland</option>
                                <option value="choose-inter">Former Yugoslav Republic of Macedonia</option>
                                <option value="choose-inter">France</option>
                                <option value="choose-inter">France, Metropolitan</option>
                                <option value="choose-inter">French Guiana</option>
                                <option value="choose-inter">French Polynesia</option>
                                <option value="choose-inter">French Southern Territories</option>
                                <option value="choose-inter">Gabon</option>
                                <option value="choose-inter">Georgia</option>
                                <option value="choose-inter">Germany</option>
                                <option value="ghana-payment">Ghana</option>
                                <option value="choose-uk">Gibraltar</option>
                                <option value="choose-inter">Greece</option>
                                <option value="choose-inter">Greenland</option>
                                <option value="choose-inter">Grenada</option>
                                <option value="choose-inter">Guadeloupe</option>
                                <option value="choose-inter">Guam</option>
                                <option value="choose-inter">Guatemala</option>
                                <option value="choose-inter">Guinea</option>
                                <option value="choose-inter">Guinea-Bissau</option>
                                <option value="choose-inter">Guyana</option>
                                <option value="choose-inter">Haiti</option>
                                <option value="choose-inter">Heard and Mc Donald Islands</option>
                                <option value="choose-inter">Honduras</option>
                                <option value="choose-inter">Hong Kong</option>
                                <option value="choose-inter">Hungary</option>
                                <option value="choose-inter">Iceland</option>
                                <option value="choose-inter">India</option>
                                <option value="choose-inter">Indonesia</option>
                                <option value="choose-inter">Iran</option>
                                <option value="choose-inter">Iraq</option>
                                <option value="choose-inter">Ireland</option>
                                <option value="choose-inter">Israel</option>
                                <option value="choose-inter">Italy</option>
                                <option value="choose-inter">Jamaica</option>
                                <option value="choose-inter">Japan</option>
                                <option value="choose-inter">Jordan</option>
                                <option value="choose-inter">Kazakhstan</option>
                                <option value="kenya-payment">Kenya</option>
                                <option value="choose-inter">Kiribati</option>
                                <option value="choose-inter">Kuwait</option>
                                <option value="choose-inter">Kyrgyzstan</option>
                                <option value="choose-inter">Laos</option>
                                <option value="choose-inter">Latvia</option>
                                <option value="choose-inter">Lebanon</option>
                                <option value="choose-inter">Lesotho</option>
                                <option value="choose-inter">Liberia</option>
                                <option value="choose-inter">Libya</option>
                                <option value="choose-inter">Liechtenstein</option>
                                <option value="choose-inter">Lithuania</option>
                                <option value="choose-inter">Luxembourg</option>
                                <option value="choose-inter">Macau</option>
                                <option value="choose-inter">Madagascar</option>
                                <option value="choose-inter">Malawi</option>
                                <option value="choose-inter">Malaysia</option>
                                <option value="choose-inter">Maldives</option>
                                <option value="choose-inter">Mali</option>
                                <option value="choose-inter">Malta</option>
                                <option value="choose-inter">Marshall Islands</option>
                                <option value="choose-inter">Martinique</option>
                                <option value="choose-inter">Mauritania</option>
                                <option value="choose-inter">Mauritius</option>
                                <option value="choose-inter">Mayotte</option>
                                <option value="choose-inter">Mexico</option>
                                <option value="choose-inter">Micronesia</option>
                                <option value="choose-inter">Moldova</option>
                                <option value="choose-inter">Monaco</option>
                                <option value="choose-inter">Mongolia</option>
                                <option value="choose-inter">Montenegro</option>
                                <option value="choose-inter">Montserrat</option>
                                <option value="choose-inter">Morocco</option>
                                <option value="choose-inter">Mozambique</option>
                                <option value="choose-inter">Myanmar</option>
                                <option value="choose-inter">Namibia</option>
                                <option value="choose-inter">Nauru</option>
                                <option value="choose-inter">Nepal</option>
                                <option value="choose-inter">Netherlands</option>
                                <option value="choose-inter">Netherlands Antilles</option>
                                <option value="choose-inter">New Caledonia</option>
                                <option value="choose-inter">New Zealand</option>
                                <option value="choose-inter">Nicaragua</option>
                                <option value="choose-inter">Niger</option>
                                <option value="local">Nigeria</option>
                                <option value="choose-uk">Nothern ireland</option>
                                <option value="choose-inter">Oman</option>
                                <option value="choose-inter">Pakistan</option>
                                <option value="choose-inter">Palau</option>
                                <option value="choose-inter">Palestine</option>
                                <option value="choose-inter">Panama</option>
                                <option value="choose-inter">Papua New Guinea</option>
                                <option value="choose-inter">Paraguay</option>
                                <option value="choose-inter">Peru</option>
                                <option value="choose-inter">Philippines</option>
                                <option value="choose-inter">Pitcairn Islands</option>
                                <option value="choose-inter">Poland</option>
                                <option value="choose-inter">Portugal</option>
                                <option value="choose-inter">Puerto Rico</option>
                                <option value="choose-inter">Qatar</option>
                                <option value="choose-inter">Reunion</option>
                                <option value="choose-inter">Romania</option>
                                <option value="choose-inter">Russia</option>
                                <option value="rwanda-payment">Rwanda</option>
                                <option value="choose-inter">São Tomé and Príncipe</option>
                                <option value="choose-inter">Saint Helena</option>
                                <option value="choose-inter">St. Pierre and Miquelon</option>
                                <option value="choose-inter">Saint Kitts and Nevis</option>
                                <option value="choose-inter">Saint Lucia</option>
                                <option value="choose-inter">Saint Vincent and the Grenadines</option>
                                <option value="choose-inter">Samoa</option>
                                <option value="choose-inter">San Marino</option>
                                <option value="choose-inter">Saudi Arabia</option>
                                <option value="choose-inter">Senegal</option>
                                <option value="choose-inter">Serbia</option>
                                <option value="choose-inter">Seychelles</option>
                                <option value="choose-inter">Sierra Leone</option>
                                <option value="choose-inter">Singapore</option>
                                <option value="choose-inter">Slovakia</option>
                                <option value="choose-uk">Scotland</option>
                                <option value="choose-inter">Slovenia</option>
                                <option value="choose-inter">Solomon Islands</option>
                                <option value="choose-inter">Somalia</option>
                                <option value="choose-inter">South Africa</option>
                                <option value="choose-inter">South Georgia and the South Sandwich Islands</option>
                                <option value="choose-inter">South Korea</option>
                                <option value="choose-inter">Spain</option>
                                <option value="choose-inter">Sri Lanka</option>
                                <option value="choose-inter">Sudan</option>
                                <option value="choose-inter">Suriname</option>
                                <option value="choose-inter">Svalbard and Jan Mayen Islands</option>
                                <option value="choose-inter">Swaziland</option>
                                <option value="choose-inter">Sweden</option>
                                <option value="choose-inter">Switzerland</option>
                                <option value="choose-inter">Syria</option>
                                <option value="choose-inter">Taiwan</option>
                                <option value="choose-inter">Tajikistan</option>
                                <option value="tanz-payment">Tanzania</option>
                                <option value="choose-inter">Thailand</option>
                                <option value="choose-inter">The Bahamas</option>
                                <option value="choose-inter">The Gambia</option>
                                <option value="choose-inter">Togo</option>
                                <option value="choose-inter">Tokelau</option>
                                <option value="choose-inter">Tonga</option>
                                <option value="choose-inter">Trinidad and Tobago</option>
                                <option value="choose-inter">Tunisia</option>
                                <option value="choose-inter">Turkey</option>
                                <option value="choose-inter">Turkmenistan</option>
                                <option value="choose-inter">Turks and Caicos Islands</option>
                                <option value="choose-inter">Tuvalu</option>
                                <option value="choose-inter">US Virgin Islands</option>
                                <option value="uganda-payment">Uganda</option>
                                <option value="choose-inter">Ukraine</option>
                                <option value="choose-inter">United Arab Emirates</option>
                                <option value="choose-inter">United Kingdom</option>
                                <option value="choose-inter">United States</option>
                                <option value="choose-inter">United States Minor Outlying Islands</option>
                                <option value="choose-inter">Uruguay</option>
                                <option value="choose-inter">Uzbekistan</option>
                                <option value="choose-inter">Vanuatu</option>
                                <option value="choose-inter">Vatican City</option>
                                <option value="choose-inter">Venezuela</option>
                                <option value="choose-inter">Vietnam</option>
                                <option value="choose-inter">Wallis and Futuna Islands</option>
                                <option value="choose-uk">Wales</option>
                                <option value="choose-inter">Western Sahara</option>
                                <option value="choose-inter">Yemen</option>
                                <option value="zambia-payment">Zambia</option>
                                <option value="choose-inter">Zimbabwe</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
include __DIR__ . "/../../components/auth-includes/footer.inc.php";
include_once __DIR__ . '/../../components/includes/footer.inc.php';
?>
