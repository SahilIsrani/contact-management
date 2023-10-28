<!DOCTYPE html>
<html>

<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="{{asset('../css/materialize.min.css')}}" media="screen,projection" />

    <!--Import Csutom CSS-->
    <link rel="stylesheet" href="{{asset('css/style.css')}}" type="text/css">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{asset("css/custom.css")}}">
    <title>Update Contact</title>
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
            <h2>Update A Contact</h2>
        </div>
        <div id = 'alerts' class="row">
            @if (session()->has('status'))
                <div class="materialert {{session()->get('status')}}">
                    <div class="material-icons">check</div>
                    {{session()->get('message')}}
                    <button type="button" class="close-alert">×</button>
                </div>
            @endif
        </div>
        @error('primaryEmail')
            <div class="materialert danger">
                <div class="material-icons"></div>
                {{$message}}
                <button type="button" class="close-alert">×</button>
            </div>
          @enderror
          @error('primaryPhone')
            <div class="materialert danger">
                <div class="material-icons">alert</div>
                {{$message}}
                <button type="button" class="close-alert">×</button>
            </div>
          @enderror
        <div class="row">
            <form id="update-contact-form" class="col s12 formValidate" action="{{route('contacts.update',$contact)}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row mb10">
                    <div class="input-field col s6">
                        <input id="first_name" name="first_name" type="text" class="validate" data-error=".first_name_error" value={{old('first_name',$contact->first_name)}}>
                        <label for="first_name">First Name</label>
                        <div class="first_name_error"></div>
                    </div>
                    <div class="input-field col s6">
                        <input id="last_name" name="last_name" type="text" class="validate" data-error=".last_name_error" value={{old('last_name',$contact->last_name)}}>
                        <label for="last_name">Last Name</label>
                        <div class="last_name_error"></div>
                    </div>
                </div>

                <div class="row mb10">
                    <div id="email-column" class="col s6 flex f-direction-column f-align-center f-space-between">
                        @foreach ($contact->emailIds->sortByDesc('primary') as $key => $emailId)
                            <div class="w-100 flex f-align-center f-space-around">
                                <label>
                                    <input class="with-gap" name="primaryEmail" type="radio" value='{{$key}}' {{ old('primaryEmail') === null ?  ($emailId->is_primary == 1 ? 'checked' : 'unchecked') :(((int)old('primaryEmail')) === $key ? 'checked' : 'unchecked')}} />
                                    <span title="Mark as primary"></span>
                                </label>
                                <div class="input-field w-85">
                                    <input id="email" name="oldEmail[{{$emailId->id}}]" type="text" value="{{old('oldEmail.'.$emailId->id,$emailId->email)}}">
                                    <label for="email">Email</label>
                                    <div class="email_error red-text text-darken-1">
                                        @if ($errors->has('oldEmail.'.$emailId->id))
                                            {{ $errors->first('oldEmail.'.$emailId->id) }}
                                        @else
                                            @error("emailTemp.oldEmail.".$emailId->id)
                                            {{ $message }}
                                            @enderror
                                        @endif
                                    </div>
                                </div>
                                <a id="remove-btn" class="btn-floating waves-effect btn-small {{$contact->emailIds->count() == 1 ? 'disabled' : '' }} red"><i id="remove-email" class="material-icons">remove</i></a>
                            </div>
                        @endforeach
                        <div id="add-email" class="btn waves-effect waves-light">Add Email</div>
                    </div>
                    <div id="phone-column" class="col s6 flex f-direction-column f-align-center f-space-between">
                        @foreach ( $contact->phoneNumbers->sortByDesc('primary') as $key => $phoneNumber )

                            <div class="w-100 flex f-align-center f-space-around">
                                <label>
                                    <input class="with-gap" name="primaryPhone" type="radio" value='{{$key}}' {{old('primaryPhone') === null ?  ($phoneNumber->is_primary == 1 ? 'checked' : 'unchecked'):(((int)old('primaryPhone')) === $key ? 'checked':'unchecked')  }} />
                                    <span title="Mark as primary"></span>
                                </label>
                                <div class="input-field w-85">
                                    <input id="phone" name="oldPhone[{{$phoneNumber->id}}]" type="text" value="{{old('oldPhone.'.$phoneNumber->id,$phoneNumber->phone)}}">
                                    <label for="phone">Phone </label>
                                    <div class="phone_error red-text text-darken-1">
                                        @if ($errors->has('oldPhone.'.$phoneNumber->id))
                                            {{$errors->first('oldPhone.'.$phoneNumber->id)}}
                                        @else
                                            @error('phoneTemp.oldPhone.'.$phoneNumber->id)
                                                {{$message}}
                                            @enderror
                                        @endif
                                    </div>
                                </div>
                                <a id="remove-btn" class="btn-floating waves-effect btn-small {{$contact->phoneNumbers->count() == 1 ? 'disabled' : '' }} red"><i id="remove-phone" class="material-icons">remove</i></a>
                            </div>
                        @endforeach
                        <div id="add-phone" class="btn waves-effect waves-light">Add Phone</div>
                    </div>
                </div>
                <div class="row mb10">
                    <div class="input-field col s12">
                        <input id="birthdate" name="birthdate" type="text" class="datepicker"  value="{{old('birthdate',$contact->birthdate)}}">
                        <label for="birthdate">Birthdate</label>
                        <div for="birthday_error" class="red-text text-darken-1"> @error('birthdate'){{$message}}@enderror</div>
                    </div>
                </div>
                <div class="row mb10">
                    <div class="input-field col s12">
                        <textarea id="address" name="address" class="materialize-textarea" >{{old('address',$contact->address)}}</textarea>
                        <label for="address">Addess</label>
                        <div for="address_error" class="red-text text-darken-1"> @error('address'){{$message}}@enderror</div>
                    </div>
                </div>
                <div class="row mb10">
                    <div class="col s3">
                        <img src="{{asset("storage/$contact->image")}}" width = "100%" alt="">
                    </div>
                    <div class="file-field input-field col s9">
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
                <input type="hidden" name="primaryEmailId" value="{{old('primaryEmail')}}">
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
    <!--JQuery Validation Plugin-->
    {{-- <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script> --}}
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="{{asset('../js/materialize.min.js')}}"></script>
    <!--Include Page Level Scripts-->
    {{-- <script src="{{asset('../js/pages/add-contact.js')}}"></script> --}}
    <!--Custom JS-->
    <script src="{{asset('/js/custom.js')}}" type="text/javascript"></script>
    <script>
        emailCount = {{count($contact->emailIds)}}
        phoneCount = {{count($contact->phoneNumbers)}}
    </script>
    @if(old('email') !== null)
    @php
        $emailCount = count(old('email'));
        $email = old('email');
        $emailKeys = array_keys($email);
        $i = 1;
        $emailError = '';
    @endphp
    <script>
        let value = '';
        @for($i = 0; $i<$emailCount;$i++)
            @php
                if ($errors->has("emailTemp.email.".$emailKeys[$i]))
                    $emailError = $errors->first("emailTemp.email.".$emailKeys[$i]);
                else
                    $emailError = $errors->first('email.'.$emailKeys[$i]);

                $radioStatus = (int)old('primaryEmail') === count($contact->emailIds)+$i ? 'checked' : 'unchecked';
            @endphp
            value = `{{$email[$emailKeys[$i]]}}`
            addEmail('{{$radioStatus}}',value,`{{$emailError}}`);
        @endfor
    </script>
    @endif
    @if(old('phone') !== null)
    @php
        $phoneCount = count(old('phone'));
        $phone = old('phone');
        $phoneKeys = array_keys($phone);
        $i = 1;
        $phoneError = '';
    @endphp
    <script>
        value = '';
        @for($i = 0; $i<$phoneCount;$i++)
            @php
                if ($errors->has("phoneTemp.phone.".$phoneKeys[$i]))
                    $phoneError = $errors->first("phoneTemp.phone.".$phoneKeys[$i]);
                else
                    $phoneError = $errors->first('phone.'.$phoneKeys[$i]);

                $radioStatus = (int)old('primaryPhone') === count($contact->phoneNumbers)+$i ? 'checked' : 'unchecked';
            @endphp
            value = `{{$phone[$phoneKeys[$i]]}}`
            addPhone('{{$radioStatus}}',value,`{{$phoneError}}`);
        @endfor
    </script>
    @endif
</body>
</html>
