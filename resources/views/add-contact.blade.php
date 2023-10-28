<!DOCTYPE html>
<html>

<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css" media="screen,projection" />

    <!--Import Csutom CSS-->
    <link rel="stylesheet" href="{{asset('css/style.css')}}" type="text/css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{asset("css/custom.css")}}">
    <title>Add Contact</title>
</head>

<body>
    <!--NAVIGATION BAR-->
    <nav>
        <div class="nav-wrapper">
            <!-- Dropdown Structure -->
            <ul id="dropdown1" class="dropdown-content">
                <li><a href="#!">Profile</a></li>
                <li><a href="#!">Signout</a></li>
            </ul>
            <nav>
                <div class="nav-wrapper">
                    <a href="#!" class="brand-logo center">Contact Info</a>
                    <ul class="right hide-on-med-and-down">
                        <!-- Dropdown Trigger -->
                        <li><a class="dropdown-trigger" href="#!" data-target="dropdown1"><i
                                    class="material-icons right">more_vert</i></a></li>
                    </ul>
                </div>
            </nav>
            <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        </div>
    </nav>
    <!--/NAVIGATION BAR-->
    <div class="container">
        <div class="row mt50">
            <h2>Add New Contact</h2>
        </div>
        <div id="alerts" class="row">
            @if (session()->has('status'))
                <div class="materialert {{session()->get('status')}}">
                    <div class="material-icons">check</div>
                    {{session()->get('message')}}
                    <button type="button" class="close-alert">×</button>
                </div>
            @endif
          @error('primaryEmail')
            <div class="materialert fail">
                <div class="material-icons">check</div>
                {{$message}}
                <button type="button" class="close-alert">×</button>
            </div>
          @enderror
          @error('primaryPhone')
            <div class="materialert fail">
                <div class="material-icons">check</div>
                {{$message}}
                <button type="button" class="close-alert">×</button>
            </div>
          @enderror

        </div>
        <div class="row">
            <form id="add-contact-form" class="col s12 formValidate" action={{route('contacts.store')}} method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb10">
                    <div class="input-field col s6">
                        <input id="first_name" name="first_name" type="text" class="validate" data-error=".first_name_error" value="{{old('first_name')}}">
                        <label for="first_name">First Name</label>
                        <div class="first_name_error" ></div>
                        {{-- <div class="first_name_error red-text text-darken-1"> @error('first_name') {{ $message }} @enderror</div> --}}

                    </div>
                    <div class="input-field col s6">
                        <input id="last_name" name="last_name" type="text" class="validate" data-error=".last_name_error" value="{{old('last_name')}}">
                        <label for="last_name">Last Name</label>
                        <div class="last_name_error "></div>
                    </div>
                </div>
                <div class="row mb10">
                    <div id="email-column" class="col s6 flex f-direction-column f-align-center f-space-between">
                        <div class="w-100 flex f-align-center f-space-around">
                            <label>
                                <input class="with-gap" name="primaryEmail" type="radio"  value='0' {{old('primaryEmail') == '0' ? 'checked' : 'unchecked'}}  />
                                <span title="Mark as primary"></span>
                            </label>
                            <div class="input-field w-85">
                                <input id="email" name="email[]" type="text" value="{{old('email.0')}}">
                                <label for="email">Email</label>
                                <div class="email_error red-text text-darken-1"> @error('email.0') {{ $message }} @enderror</div>
                            </div>
                            <a id='remove-btn' class="btn-floating waves-effect btn-small disabled red"><i id="remove-email" class="material-icons">remove</i></a>
                        </div>
                        <div id="add-email" class="btn waves-effect waves-light">Add Email</div>
                    </div>
                    <div id="phone-column" class="col s6 flex f-direction-column f-align-center f-space-between">
                        <div class="w-100 flex f-align-center f-space-around">
                            <label>
                                <input class="with-gap" name="primaryPhone" type="radio" value='0'  {{old('primaryPhone') == '0' ? 'checked' : 'unchecked'}} />
                                <span title="Mark as primary"></span>
                            </label>
                            <div class="input-field w-85">
                                <input id="phone" name="phone[]" type="text" value="{{old('phone.0')}}">
                                <label for="phone">Telephone</label>
                                <div for="phone_error" class="red-text text-darken-1"> @error('phone.0') {{ $message }}@enderror </div>
                            </div>
                            <a id="remove-btn" class="btn-floating waves-effect btn-small disabled red"><i id="remove-phone" class="material-icons">remove</i></a>
                        </div>
                        <div id="add-phone" class="btn waves-effect waves-light">Add Phone</div>
                    </div>
                </div>
                <div class="row mb10">
                    <div class="input-field col s12">
                        <input id="birthdate" name="birthdate" type="text" class="datepicker" data-error=".birthday_error" value="{{old('birthdate')}}">
                        <label for="birthdate">Birthdate</label>
                        <div class="birthday_error red-text text-darken-1" > @error('birthdate') {{$message}} @enderror </div>
                    </div>
                </div>
                <div class="row mb10">
                    <div class="input-field col s12">
                        <textarea id="address" name="address" class="materialize-textarea" data-error=".address_error">{{old('address')}}</textarea>
                        <label for="address">Addess</label>
                        <div class="address_error red-text text-darken-1"> @error('address') {{$message}} @enderror </div>
                    </div>
                </div>
                <div class="row mb10">
                    <div class="file-field input-field col s12">
                        <div class="btn">
                            <span>Image</span>
                            <input type="file" name="image" id="pic" data-error=".pic_error">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Upload Your Image">
                        </div>
                        <div class="pic_error "></div>
                    </div>
                </div>
                <button class="btn waves-effect waves-light right" type="submit" name="action">Submit
                        <i class="material-icons right">send</i>
                    </button>
                <input type="hidden" name="primaryEmailId">
                <input type="hidden" name="primaryPhoneNumber">
            </form>
        </div>
    </div>
    <footer class="page-footer p0">
        <div class="footer-copyright ">
            <div class="container">
                <p class="center-align">© 2020 Study Link Classes</p>
            </div>
        </div>
    </footer>
    <!--JQuery Library-->
    <script src="{{asset('../js/jquery.min.js')}}" type="text/javascript"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script> --}}
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="{{asset('../js/materialize.min.js')}}"></script>
    <!--Include Page Level Scripts-->
    {{-- <script src="{{asset('../js/pages/add-contact.js')}}"></script> --}}
    <!--Custom JS-->
    <script src="{{asset('/js/custom.js')}}" type="text/javascript"></script>
    @if(old('email') !== null)
    @php
        $emailCount = count(old('email'));
        $email = old('email');
        $radioStatus = 'unchecked';
        $i = 1
    @endphp
    <script>
        let value = '';
        @for($i = 1; $i<$emailCount;$i++)
            @php
                $radioStatus = old('primaryEmail') == $i ? 'checked':'unchecked';
            @endphp
            value = `{{$email[$i]}}`
            addEmail(`{{$radioStatus}}`,value,`{{head($errors->get(('email.'.$i)))}}`);
        @endfor
    </script>
    @endif
    @if(old('phone') !== null)
    @php
        $phoneCount = count(old('phone'));
        $phone = old('phone');
        $radioStatus = 'unchecked';
        $i = 1
    @endphp
    <script>
        // let value = '';
        @for($i = 1; $i<$phoneCount;$i++)
            @php
            $radioStatus = old('primaryPhone') == $i ? 'checked':'unchecked';
            @endphp
            value = `{{$phone[$i]}}`
            addPhone(`{{$radioStatus}}`,value,`{{head($errors->get(('phone.'.$i)))}}`);
        @endfor
    </script>
    @endif
    </body>
</html>
