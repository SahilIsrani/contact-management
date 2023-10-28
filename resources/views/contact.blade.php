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
    <title>Contact details</title>
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
            <div class="col s12 center-align" >
                <img class="circle" src="{{asset("storage/$contact->image")}}" alt="" width = '200px' height = "200px">
            </div>
        </div>
        <div class="row">
            <form id="add-contact-form" class="col s12 formValidate">
                <div class="row mb10">
                    <div class="input-field col s6">
                        <input id="first_name" name="first_name" type="text" class="validate" disabled  value="{{$contact->first_name}}">
                        <label for="first_name" class="active" >First Name</label>
                    </div>
                    <div class="input-field col s6">
                        <input id="last_name" name="last_name" type="text" class="validate" disabled  value="{{$contact->last_name}}">
                        <label for="last_name">Last Name</label>
                    </div>
                </div>
                <div class="row mb10">
                    <div id="email-column" class="col s6 flex f-direction-column f-align-center f-space-between">
                        @foreach ($contact->emailIds->sortByDesc('primary') as $email)
                            <div class="w-100 flex f-align-center f-space-between">
                                <label>
                                    <input class="with-gap" name="primaryEmail" type="radio"  value='0' {{$email->is_primary ? 'checked' : 'unchecked'}} disabled  />
                                    @if ($email->is_primary)
                                        <span title="Primary Email"></span>
                                    @else
                                        <span></span>
                                    @endif

                                </label>
                                <div class="input-field w-90">
                                    <input id="email" name="email[]" type="text" disabled value="{{$email->email}}">
                                    <label for="email">Email</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div id="phone-column" class="col s6 flex f-direction-column f-align-center f-space-between">
                        @foreach ($contact->phoneNumbers->sortByDesc('primary') as $phoneNumber)
                            <div class="w-100 flex f-align-center f-space-between">
                                <label>
                                    <input class="with-gap" name="primaryPhone" type="radio"  value='0'  {{$phoneNumber->is_primary  ? 'checked' : 'unchecked'}} disabled />
                                    @if ($phoneNumber->is_primary )
                                        <span title="Primary Email"></span>
                                    @else
                                        <span></span>
                                    @endif
                                </label>
                                <div class="input-field w-90">
                                    <input id="phone" name="phone[]" type="text" disabled value="{{$phoneNumber->phone}}">
                                    <label for="phone">Telephone</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="row mb10">
                    <div class="input-field col s12">
                        <input id="birthdate" name="birthdate" type="text" class="datepicker" disabled value="{{$contact->birthdate}}">
                        <label for="birthdate">Birthdate</label>
                        <div class="birthday_error red-text text-darken-1"> @error('birthdate') {{$message}} @enderror </div>
                    </div>
                </div>
                <div class="row mb10">
                    <div class="input-field col s12">
                        <textarea id="address" name="address" class="materialize-textarea" disabled >{{$contact->address}}</textarea>
                        <label for="address">Addess</label>
                    </div>
                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="{{asset('../js/materialize.min.js')}}"></script>
    <!--Include Page Level Scripts-->
    <script src="{{asset('../js/pages/add-contact.js')}}"></script>
    <!--Custom JS-->
    <script src="{{asset('/js/custom.js')}}" type="text/javascript"></script>

    </body>
</html>
