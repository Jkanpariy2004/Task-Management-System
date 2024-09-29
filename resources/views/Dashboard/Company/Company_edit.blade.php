<link rel="stylesheet" href="/assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="/assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="/assets/css/demo.css" />
<!-- Add Flatpickr CSS -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" /> -->
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('Dashboard.Layouts.Sidenavbar')

        <div class="layout-page">

            @include('Dashboard.Layouts.header')


            <div class="content-wrapper">

                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="col-md-12">
                        <div class="card mb-4">
                            <h5 class="card-header">Update Company</h5>
                            <div class="card-body">
                                <form id="CompanyForm">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="c_name" class="form-label">Company Name</label>
                                        <input type="text" class="form-control" name="c_name" id="c_name" value="{{ $new->c_name }}" placeholder="Enter Company Name" />
                                        <div class="invalid-feedback" id="c_name-error"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="c_email" class="form-label">Company Email</label>
                                        <input type="email" class="form-control" name="c_email" id="c_email" value="{{ $new->c_email }}" placeholder="Enter Company Email" />
                                        <div class="invalid-feedback" id="c_email-error"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="c_mobile" class="form-label">Company Mobile</label>
                                        <input type="text" class="form-control" name="c_mobile" id="c_mobile" value="{{ $new->c_phone_no }}" placeholder="Enter Company Mobile" />
                                        <div class="invalid-feedback" id="c_mobile-error"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="c_address" class="form-label">Company Address</label>
                                        <textarea type="text" class="form-control" name="c_address" id="c_address" placeholder="Enter Company Address">{{ $new->c_address }}</textarea>
                                        <div class="invalid-feedback" id="c_address-error"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" class="form-control" name="city" id="city" value="{{ $new->city }}" placeholder="Enter Company City" />
                                        <div class="invalid-feedback" id="city-error"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <select class="form-select" id="country" name="country">
                                            <option value="" hidden>Select Country</option>
                                            <option value="Afghanistan" {{ $new->country == 'Afghanistan' ? 'selected' : '' }}>Afghanistan</option>
                                            <option value="Albania" {{ $new->country == 'Albania' ? 'selected' : '' }}>Albania</option>
                                            <option value="Algeria" {{ $new->country == 'Algeria' ? 'selected' : '' }}>Algeria</option>
                                            <option value="Andorra" {{ $new->country == 'Andorra' ? 'selected' : '' }}>Andorra</option>
                                            <option value="Angola" {{ $new->country == 'Angola' ? 'selected' : '' }}>Angola</option>
                                            <option value="Antigua and Barbuda" {{ $new->country == 'Antigua and Barbuda' ? 'selected' : '' }}>Antigua and Barbuda</option>
                                            <option value="Argentina" {{ $new->country == 'Argentina' ? 'selected' : '' }}>Argentina</option>
                                            <option value="Armenia" {{ $new->country == 'Armenia' ? 'selected' : '' }}>Armenia</option>
                                            <option value="Australia" {{ $new->country == 'Australia' ? 'selected' : '' }}>Australia</option>
                                            <option value="Austria" {{ $new->country == 'Austria' ? 'selected' : '' }}>Austria</option>
                                            <option value="Azerbaijan" {{ $new->country == 'Azerbaijan' ? 'selected' : '' }}>Azerbaijan</option>
                                            <option value="Bahamas" {{ $new->country == 'Bahamas' ? 'selected' : '' }}>Bahamas</option>
                                            <option value="Bahrain" {{ $new->country == 'Bahrain' ? 'selected' : '' }}>Bahrain</option>
                                            <option value="Bangladesh" {{ $new->country == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                            <option value="Barbados" {{ $new->country == 'Barbados' ? 'selected' : '' }}>Barbados</option>
                                            <option value="Belarus" {{ $new->country == 'Belarus' ? 'selected' : '' }}>Belarus</option>
                                            <option value="Belgium" {{ $new->country == 'Belgium' ? 'selected' : '' }}>Belgium</option>
                                            <option value="Belize" {{ $new->country == 'Belize' ? 'selected' : '' }}>Belize</option>
                                            <option value="Benin" {{ $new->country == 'Benin' ? 'selected' : '' }}>Benin</option>
                                            <option value="Bhutan" {{ $new->country == 'Bhutan' ? 'selected' : '' }}>Bhutan</option>
                                            <option value="Bolivia" {{ $new->country == 'Bolivia' ? 'selected' : '' }}>Bolivia</option>
                                            <option value="Bosnia and Herzegovina" {{ $new->country == 'Bosnia and Herzegovina' ? 'selected' : '' }}>Bosnia and Herzegovina</option>
                                            <option value="Botswana" {{ $new->country == 'Botswana' ? 'selected' : '' }}>Botswana</option>
                                            <option value="Brazil" {{ $new->country == 'Brazil' ? 'selected' : '' }}>Brazil</option>
                                            <option value="Brunei" {{ $new->country == 'Brunei' ? 'selected' : '' }}>Brunei</option>
                                            <option value="Bulgaria" {{ $new->country == 'Bulgaria' ? 'selected' : '' }}>Bulgaria</option>
                                            <option value="Burkina Faso" {{ $new->country == 'Burkina Faso' ? 'selected' : '' }}>Burkina Faso</option>
                                            <option value="Burundi" {{ $new->country == 'Burundi' ? 'selected' : '' }}>Burundi</option>
                                            <option value="Cabo Verde" {{ $new->country == 'Cabo Verde' ? 'selected' : '' }}>Cabo Verde</option>
                                            <option value="Cambodia" {{ $new->country == 'Cambodia' ? 'selected' : '' }}>Cambodia</option>
                                            <option value="Cameroon" {{ $new->country == 'Cameroon' ? 'selected' : '' }}>Cameroon</option>
                                            <option value="Canada" {{ $new->country == 'Canada' ? 'selected' : '' }}>Canada</option>
                                            <option value="Central African Republic" {{ $new->country == 'Central African Republic' ? 'selected' : '' }}>Central African Republic</option>
                                            <option value="Chad" {{ $new->country == 'Chad' ? 'selected' : '' }}>Chad</option>
                                            <option value="Chile" {{ $new->country == 'Chile' ? 'selected' : '' }}>Chile</option>
                                            <option value="China" {{ $new->country == 'China' ? 'selected' : '' }}>China</option>
                                            <option value="Colombia" {{ $new->country == 'Colombia' ? 'selected' : '' }}>Colombia</option>
                                            <option value="Comoros" {{ $new->country == 'Comoros' ? 'selected' : '' }}>Comoros</option>
                                            <option value="Congo" {{ $new->country == 'Congo' ? 'selected' : '' }}>Congo</option>
                                            <option value="Costa Rica" {{ $new->country == 'Costa Rica' ? 'selected' : '' }}>Costa Rica</option>
                                            <option value="Croatia" {{ $new->country == 'Croatia' ? 'selected' : '' }}>Croatia</option>
                                            <option value="Cuba" {{ $new->country == 'Cuba' ? 'selected' : '' }}>Cuba</option>
                                            <option value="Cyprus" {{ $new->country == 'Cyprus' ? 'selected' : '' }}>Cyprus</option>
                                            <option value="Czech Republic" {{ $new->country == 'Czech Republic' ? 'selected' : '' }}>Czech Republic</option>
                                            <option value="Denmark" {{ $new->country == 'Denmark' ? 'selected' : '' }}>Denmark</option>
                                            <option value="Djibouti" {{ $new->country == 'Djibouti' ? 'selected' : '' }}>Djibouti</option>
                                            <option value="Dominica" {{ $new->country == 'Dominica' ? 'selected' : '' }}>Dominica</option>
                                            <option value="Dominican Republic" {{ $new->country == 'Dominican Republic' ? 'selected' : '' }}>Dominican Republic</option>
                                            <option value="East Timor" {{ $new->country == 'East Timor' ? 'selected' : '' }}>East Timor</option>
                                            <option value="Ecuador" {{ $new->country == 'Ecuador' ? 'selected' : '' }}>Ecuador</option>
                                            <option value="Egypt" {{ $new->country == 'Egypt' ? 'selected' : '' }}>Egypt</option>
                                            <option value="El Salvador" {{ $new->country == 'El Salvador' ? 'selected' : '' }}>El Salvador</option>
                                            <option value="Equatorial Guinea" {{ $new->country == 'Equatorial Guinea' ? 'selected' : '' }}>Equatorial Guinea</option>
                                            <option value="Eritrea" {{ $new->country == 'Eritrea' ? 'selected' : '' }}>Eritrea</option>
                                            <option value="Estonia" {{ $new->country == 'Estonia' ? 'selected' : '' }}>Estonia</option>
                                            <option value="Eswatini" {{ $new->country == 'Eswatini' ? 'selected' : '' }}>Eswatini</option>
                                            <option value="Ethiopia" {{ $new->country == 'Ethiopia' ? 'selected' : '' }}>Ethiopia</option>
                                            <option value="Fiji" {{ $new->country == 'Fiji' ? 'selected' : '' }}>Fiji</option>
                                            <option value="Finland" {{ $new->country == 'Finland' ? 'selected' : '' }}>Finland</option>
                                            <option value="France" {{ $new->country == 'France' ? 'selected' : '' }}>France</option>
                                            <option value="Gabon" {{ $new->country == 'Gabon' ? 'selected' : '' }}>Gabon</option>
                                            <option value="Gambia" {{ $new->country == 'Gambia' ? 'selected' : '' }}>Gambia</option>
                                            <option value="Georgia" {{ $new->country == 'Georgia' ? 'selected' : '' }}>Georgia</option>
                                            <option value="Germany" {{ $new->country == 'Germany' ? 'selected' : '' }}>Germany</option>
                                            <option value="Ghana" {{ $new->country == 'Ghana' ? 'selected' : '' }}>Ghana</option>
                                            <option value="Greece" {{ $new->country == 'Greece' ? 'selected' : '' }}>Greece</option>
                                            <option value="Grenada" {{ $new->country == 'Grenada' ? 'selected' : '' }}>Grenada</option>
                                            <option value="Guatemala" {{ $new->country == 'Guatemala' ? 'selected' : '' }}>Guatemala</option>
                                            <option value="Guinea" {{ $new->country == 'Guinea' ? 'selected' : '' }}>Guinea</option>
                                            <option value="Guinea-Bissau" {{ $new->country == 'Guinea-Bissau' ? 'selected' : '' }}>Guinea-Bissau</option>
                                            <option value="Guyana" {{ $new->country == 'Guyana' ? 'selected' : '' }}>Guyana</option>
                                            <option value="Haiti" {{ $new->country == 'Haiti' ? 'selected' : '' }}>Haiti</option>
                                            <option value="Honduras" {{ $new->country == 'Honduras' ? 'selected' : '' }}>Honduras</option>
                                            <option value="Hungary" {{ $new->country == 'Hungary' ? 'selected' : '' }}>Hungary</option>
                                            <option value="Iceland" {{ $new->country == 'Iceland' ? 'selected' : '' }}>Iceland</option>
                                            <option value="India" {{ $new->country == 'India' ? 'selected' : '' }}>India</option>
                                            <option value="Indonesia" {{ $new->country == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                            <option value="Iran" {{ $new->country == 'Iran' ? 'selected' : '' }}>Iran</option>
                                            <option value="Iraq" {{ $new->country == 'Iraq' ? 'selected' : '' }}>Iraq</option>
                                            <option value="Ireland" {{ $new->country == 'Ireland' ? 'selected' : '' }}>Ireland</option>
                                            <option value="Israel" {{ $new->country == 'Israel' ? 'selected' : '' }}>Israel</option>
                                            <option value="Italy" {{ $new->country == 'Italy' ? 'selected' : '' }}>Italy</option>
                                            <option value="Jamaica" {{ $new->country == 'Jamaica' ? 'selected' : '' }}>Jamaica</option>
                                            <option value="Japan" {{ $new->country == 'Japan' ? 'selected' : '' }}>Japan</option>
                                            <option value="Jordan" {{ $new->country == 'Jordan' ? 'selected' : '' }}>Jordan</option>
                                            <option value="Kazakhstan" {{ $new->country == 'Kazakhstan' ? 'selected' : '' }}>Kazakhstan</option>
                                            <option value="Kenya" {{ $new->country == 'Kenya' ? 'selected' : '' }}>Kenya</option>
                                            <option value="Kiribati" {{ $new->country == 'Kiribati' ? 'selected' : '' }}>Kiribati</option>
                                            <option value="Korea" {{ $new->country == 'Korea' ? 'selected' : '' }}>Korea</option>
                                            <option value="Kosovo" {{ $new->country == 'Kosovo' ? 'selected' : '' }}>Kosovo</option>
                                            <option value="Kuwait" {{ $new->country == 'Kuwait' ? 'selected' : '' }}>Kuwait</option>
                                            <option value="Kyrgyzstan" {{ $new->country == 'Kyrgyzstan' ? 'selected' : '' }}>Kyrgyzstan</option>
                                            <option value="Laos" {{ $new->country == 'Laos' ? 'selected' : '' }}>Laos</option>
                                            <option value="Latvia" {{ $new->country == 'Latvia' ? 'selected' : '' }}>Latvia</option>
                                            <option value="Lebanon" {{ $new->country == 'Lebanon' ? 'selected' : '' }}>Lebanon</option>
                                            <option value="Lesotho" {{ $new->country == 'Lesotho' ? 'selected' : '' }}>Lesotho</option>
                                            <option value="Liberia" {{ $new->country == 'Liberia' ? 'selected' : '' }}>Liberia</option>
                                            <option value="Libya" {{ $new->country == 'Libya' ? 'selected' : '' }}>Libya</option>
                                            <option value="Liechtenstein" {{ $new->country == 'Liechtenstein' ? 'selected' : '' }}>Liechtenstein</option>
                                            <option value="Lithuania" {{ $new->country == 'Lithuania' ? 'selected' : '' }}>Lithuania</option>
                                            <option value="Luxembourg" {{ $new->country == 'Luxembourg' ? 'selected' : '' }}>Luxembourg</option>
                                            <option value="Madagascar" {{ $new->country == 'Madagascar' ? 'selected' : '' }}>Madagascar</option>
                                            <option value="Malawi" {{ $new->country == 'Malawi' ? 'selected' : '' }}>Malawi</option>
                                            <option value="Malaysia" {{ $new->country == 'Malaysia' ? 'selected' : '' }}>Malaysia</option>
                                            <option value="Maldives" {{ $new->country == 'Maldives' ? 'selected' : '' }}>Maldives</option>
                                            <option value="Mali" {{ $new->country == 'Mali' ? 'selected' : '' }}>Mali</option>
                                            <option value="Malta" {{ $new->country == 'Malta' ? 'selected' : '' }}>Malta</option>
                                            <option value="Marshall Islands" {{ $new->country == 'Marshall Islands' ? 'selected' : '' }}>Marshall Islands</option>
                                            <option value="Mauritania" {{ $new->country == 'Mauritania' ? 'selected' : '' }}>Mauritania</option>
                                            <option value="Mauritius" {{ $new->country == 'Mauritius' ? 'selected' : '' }}>Mauritius</option>
                                            <option value="Mexico" {{ $new->country == 'Mexico' ? 'selected' : '' }}>Mexico</option>
                                            <option value="Micronesia" {{ $new->country == 'Micronesia' ? 'selected' : '' }}>Micronesia</option>
                                            <option value="Moldova" {{ $new->country == 'Moldova' ? 'selected' : '' }}>Moldova</option>
                                            <option value="Monaco" {{ $new->country == 'Monaco' ? 'selected' : '' }}>Monaco</option>
                                            <option value="Mongolia" {{ $new->country == 'Mongolia' ? 'selected' : '' }}>Mongolia</option>
                                            <option value="Montenegro" {{ $new->country == 'Montenegro' ? 'selected' : '' }}>Montenegro</option>
                                            <option value="Morocco" {{ $new->country == 'Morocco' ? 'selected' : '' }}>Morocco</option>
                                            <option value="Mozambique" {{ $new->country == 'Mozambique' ? 'selected' : '' }}>Mozambique</option>
                                            <option value="Myanmar" {{ $new->country == 'Myanmar' ? 'selected' : '' }}>Myanmar</option>
                                            <option value="Namibia" {{ $new->country == 'Namibia' ? 'selected' : '' }}>Namibia</option>
                                            <option value="Nauru" {{ $new->country == 'Nauru' ? 'selected' : '' }}>Nauru</option>
                                            <option value="Nepal" {{ $new->country == 'Nepal' ? 'selected' : '' }}>Nepal</option>
                                            <option value="Netherlands" {{ $new->country == 'Netherlands' ? 'selected' : '' }}>Netherlands</option>
                                            <option value="New Zealand" {{ $new->country == 'New Zealand' ? 'selected' : '' }}>New Zealand</option>
                                            <option value="Nicaragua" {{ $new->country == 'Nicaragua' ? 'selected' : '' }}>Nicaragua</option>
                                            <option value="Niger" {{ $new->country == 'Niger' ? 'selected' : '' }}>Niger</option>
                                            <option value="Nigeria" {{ $new->country == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                                            <option value="Norway" {{ $new->country == 'Norway' ? 'selected' : '' }}>Norway</option>
                                            <option value="Oman" {{ $new->country == 'Oman' ? 'selected' : '' }}>Oman</option>
                                            <option value="Pakistan" {{ $new->country == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                            <option value="Palau" {{ $new->country == 'Palau' ? 'selected' : '' }}>Palau</option>
                                            <option value="Palestine" {{ $new->country == 'Palestine' ? 'selected' : '' }}>Palestine</option>
                                            <option value="Panama" {{ $new->country == 'Panama' ? 'selected' : '' }}>Panama</option>
                                            <option value="Papua New Guinea" {{ $new->country == 'Papua New Guinea' ? 'selected' : '' }}>Papua New Guinea</option>
                                            <option value="Paraguay" {{ $new->country == 'Paraguay' ? 'selected' : '' }}>Paraguay</option>
                                            <option value="Peru" {{ $new->country == 'Peru' ? 'selected' : '' }}>Peru</option>
                                            <option value="Philippines" {{ $new->country == 'Philippines' ? 'selected' : '' }}>Philippines</option>
                                            <option value="Poland" {{ $new->country == 'Poland' ? 'selected' : '' }}>Poland</option>
                                            <option value="Portugal" {{ $new->country == 'Portugal' ? 'selected' : '' }}>Portugal</option>
                                            <option value="Qatar" {{ $new->country == 'Qatar' ? 'selected' : '' }}>Qatar</option>
                                            <option value="Romania" {{ $new->country == 'Romania' ? 'selected' : '' }}>Romania</option>
                                            <option value="Russia" {{ $new->country == 'Russia' ? 'selected' : '' }}>Russia</option>
                                            <option value="Rwanda" {{ $new->country == 'Rwanda' ? 'selected' : '' }}>Rwanda</option>
                                            <option value="Saint Kitts and Nevis" {{ $new->country == 'Saint Kitts and Nevis' ? 'selected' : '' }}>Saint Kitts and Nevis</option>
                                            <option value="Saint Lucia" {{ $new->country == 'Saint Lucia' ? 'selected' : '' }}>Saint Lucia</option>
                                            <option value="Saint Vincent and the Grenadines" {{ $new->country == 'Saint Vincent and the Grenadines' ? 'selected' : '' }}>Saint Vincent and the Grenadines</option>
                                            <option value="Samoa" {{ $new->country == 'Samoa' ? 'selected' : '' }}>Samoa</option>
                                            <option value="San Marino" {{ $new->country == 'San Marino' ? 'selected' : '' }}>San Marino</option>
                                            <option value="Sao Tome and Principe" {{ $new->country == 'Sao Tome and Principe' ? 'selected' : '' }}>Sao Tome and Principe</option>
                                            <option value="Saudi Arabia" {{ $new->country == 'Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
                                            <option value="Senegal" {{ $new->country == 'Senegal' ? 'selected' : '' }}>Senegal</option>
                                            <option value="Serbia" {{ $new->country == 'Serbia' ? 'selected' : '' }}>Serbia</option>
                                            <option value="Seychelles" {{ $new->country == 'Seychelles' ? 'selected' : '' }}>Seychelles</option>
                                            <option value="Sierra Leone" {{ $new->country == 'Sierra Leone' ? 'selected' : '' }}>Sierra Leone</option>
                                            <option value="Singapore" {{ $new->country == 'Singapore' ? 'selected' : '' }}>Singapore</option>
                                            <option value="Slovakia" {{ $new->country == 'Slovakia' ? 'selected' : '' }}>Slovakia</option>
                                            <option value="Slovenia" {{ $new->country == 'Slovenia' ? 'selected' : '' }}>Slovenia</option>
                                            <option value="Solomon Islands" {{ $new->country == 'Solomon Islands' ? 'selected' : '' }}>Solomon Islands</option>
                                            <option value="Somalia" {{ $new->country == 'Somalia' ? 'selected' : '' }}>Somalia</option>
                                            <option value="South Africa" {{ $new->country == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                                            <option value="South Sudan" {{ $new->country == 'South Sudan' ? 'selected' : '' }}>South Sudan</option>
                                            <option value="Spain" {{ $new->country == 'Spain' ? 'selected' : '' }}>Spain</option>
                                            <option value="Sri Lanka" {{ $new->country == 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
                                            <option value="Sudan" {{ $new->country == 'Sudan' ? 'selected' : '' }}>Sudan</option>
                                            <option value="Suriname" {{ $new->country == 'Suriname' ? 'selected' : '' }}>Suriname</option>
                                            <option value="Sweden" {{ $new->country == 'Sweden' ? 'selected' : '' }}>Sweden</option>
                                            <option value="Switzerland" {{ $new->country == 'Switzerland' ? 'selected' : '' }}>Switzerland</option>
                                            <option value="Syria" {{ $new->country == 'Syria' ? 'selected' : '' }}>Syria</option>
                                            <option value="Taiwan" {{ $new->country == 'Taiwan' ? 'selected' : '' }}>Taiwan</option>
                                            <option value="Tajikistan" {{ $new->country == 'Tajikistan' ? 'selected' : '' }}>Tajikistan</option>
                                            <option value="Tanzania" {{ $new->country == 'Tanzania' ? 'selected' : '' }}>Tanzania</option>
                                            <option value="Thailand" {{ $new->country == 'Thailand' ? 'selected' : '' }}>Thailand</option>
                                            <option value="Togo" {{ $new->country == 'Togo' ? 'selected' : '' }}>Togo</option>
                                            <option value="Tonga" {{ $new->country == 'Tonga' ? 'selected' : '' }}>Tonga</option>
                                            <option value="Trinidad and Tobago" {{ $new->country == 'Trinidad and Tobago' ? 'selected' : '' }}>Trinidad and Tobago</option>
                                            <option value="Tunisia" {{ $new->country == 'Tunisia' ? 'selected' : '' }}>Tunisia</option>
                                            <option value="Turkey" {{ $new->country == 'Turkey' ? 'selected' : '' }}>Turkey</option>
                                            <option value="Turkmenistan" {{ $new->country == 'Turkmenistan' ? 'selected' : '' }}>Turkmenistan</option>
                                            <option value="Tuvalu" {{ $new->country == 'Tuvalu' ? 'selected' : '' }}>Tuvalu</option>
                                            <option value="Uganda" {{ $new->country == 'Uganda' ? 'selected' : '' }}>Uganda</option>
                                            <option value="Ukraine" {{ $new->country == 'Ukraine' ? 'selected' : '' }}>Ukraine</option>
                                            <option value="United Arab Emirates" {{ $new->country == 'United Arab Emirates' ? 'selected' : '' }}>United Arab Emirates</option>
                                            <option value="United Kingdom" {{ $new->country == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                            <option value="United States" {{ $new->country == 'United States' ? 'selected' : '' }}>United States</option>
                                            <option value="Uruguay" {{ $new->country == 'Uruguay' ? 'selected' : '' }}>Uruguay</option>
                                            <option value="Uzbekistan" {{ $new->country == 'Uzbekistan' ? 'selected' : '' }}>Uzbekistan</option>
                                            <option value="Vanuatu" {{ $new->country == 'Vanuatu' ? 'selected' : '' }}>Vanuatu</option>
                                            <option value="Vatican City" {{ $new->country == 'Vatican City' ? 'selected' : '' }}>Vatican City</option>
                                            <option value="Venezuela" {{ $new->country == 'Venezuela' ? 'selected' : '' }}>Venezuela</option>
                                            <option value="Vietnam" {{ $new->country == 'Vietnam' ? 'selected' : '' }}>Vietnam</option>
                                            <option value="Yemen" {{ $new->country == 'Yemen' ? 'selected' : '' }}>Yemen</option>
                                            <option value="Zambia" {{ $new->country == 'Zambia' ? 'selected' : '' }}>Zambia</option>
                                            <option value="Zimbabwe" {{ $new->country == 'Zimbabwe' ? 'selected' : '' }}>Zimbabwe</option>
                                        </select>
                                        <div class="invalid-feedback" id="country-error"></div>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary w-100">Add Company</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @include('Dashboard.Layouts.footer')

                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>

    <div class="layout-overlay layout-menu-toggle"></div>

    <div class="drag-target"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(document).ready(function() {
        $('input, select, textarea').on('input', function() {
            $(this).removeClass('is-invalid');
            $('#' + $(this).attr('id') + '-error').text('');
        });

        $('#CompanyForm').on('submit', function(e) {
            e.preventDefault();

            var isValid = true;

            var c_name = $('#c_name').val();
            if (c_name.trim() === '') {
                $('#c_name').addClass('is-invalid');
                $('#c_name-error').text('Company Name is required');
                isValid = false;
            }

            var c_email = $('#c_email').val();
            if (c_email.trim() === '') {
                $('#c_email').addClass('is-invalid');
                $('#c_email-error').text('Company Email is required');
                isValid = false;
            }

            var c_mobile = $('#c_mobile').val();
            if (c_mobile.trim() === '') {
                $('#c_mobile').addClass('is-invalid');
                $('#c_mobile-error').text('Company Mobile is required');
                isValid = false;
            }

            var c_address = $('#c_address').val();
            if (c_address === '') {
                $('#c_address').addClass('is-invalid');
                $('#c_address-error').text('Company Address is required');
                isValid = false;
            }

            var city = $('#city').val();
            if (city === '') {
                $('#city').addClass('is-invalid');
                $('#city-error').text('City is required');
                isValid = false;
            }

            var country = $('#country').val();
            if (country.trim() === '') {
                $('#country').addClass('is-invalid');
                $('#country-error').text('Country is required');
                isValid = false;
            }

            if (isValid) {
                var formData = new FormData(this);

                $.ajax({
                    url: '{{ route("company.update", $new->id) }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            timer: 3000,
                            timerProgressBar: true,
                            confirmButtonText: 'OK'
                        }).then(function() {
                            window.location.href = '/admin/company';
                        });
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').text('');

                        $.each(errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key + '-error').text(value[0]);
                        });
                    }
                });
            }
        });
    });
</script>
