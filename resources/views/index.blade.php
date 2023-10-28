<!DOCTYPE html>
<html>

<head>
    <!--Import Google Icon Font-->
    <link href="{{asset('https://fonts.googleapis.com/icon?family=Material+Icons')}}" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="{{asset('css/materialize.min.css')}}" media="screen,projection" />

    <!--Import Csutom CSS-->
    <link rel="stylesheet" href="{{asset('css/style.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset("css/custom.css")}}">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    <div class="row">
            @if (session()->has('status'))
                <div class="materialert {{session()->get('status')}}">
                    <div class="material-icons">check</div>
                    {{session()->get('message')}}
                    <button type="button" class="close-alert">×</button>
                </div>
            @endif
    </div>
    <!-- Add a New Contact Link-->
    <div class="row mt50">
        <div class="col s12 right-align">
            <a class="btn waves-effect waves-light blue lighten-2" href="{{route('contacts.download')}}"><i class="material-icons left">file_download</i>
                Download Contacts
            </a>
            <a class="btn waves-effect waves-light blue lighten-2" href="{{route('contacts.excel.upload')}}"><i class="material-icons left">file_upload</i>
                Upload Excel
            </a>
            <a class="btn waves-effect waves-light blue lighten-2" href="{{route('contacts.create')}}"><i
                    class="material-icons left">add</i> Add
                New</a>

        </div>
    </div>
    <!-- /Add a New Contact Link-->

    <!-- Table of Contacts -->
    <div class="row">
        <div class="col s12">
            <table class="highlight centered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email ID</th>
                        <th>Date Of Birth</th>
                        <th>Phone Number</th>
                        <th>Address</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($contacts as $contact )
                        <tr>
                            <td><img class="circle" src="{{asset("storage/$contact->image")}}" alt="" width = '128px'></td>
                            <td>{{$contact->first_name." ".$contact->last_name}}</td>
                            <td>{{$contact->email}} </td>

                            <td>{{$contact->birthdate}}</td>
                            <td>{{$contact->phone}}</td>
                            <td>{{$contact->address}}</td>
                            <td><a title="View Contact" class="btn btn-floating green lighten-2" href="{{route('contacts.show',$contact->contact_id )}}"><i class="material-icons">info</i></a></td>
                            <td><a class="btn btn-floating green lighten-2" href="{{route('contacts.edit',$contact->contact_id)}}"><i class="material-icons">edit</i></a></td>
                            <td><a class="btn btn-floating red lighten-2 modal-trigger deleteBtn "  href="#deleteModal" ><i data-contact-id="{{$contact->contact_id}}" class="material-icons">delete_forever</i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /Table of Contacts -->
    <!-- Pagination -->
    {{-- @include('pagination') --}}
    {{$contacts->links('pagination')}}
    <!-- /Pagination -->
    <!-- Footer -->
    <footer class="page-footer p0">
        <div class="footer-copyright ">
            <div class="container">
                <p class="center-align">© 2020 Study Link Classes</p>
            </div>
        </div>
    </footer>
    <!-- /Footer -->
    <!-- Delete Modal Structure -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h4>Delete Contact?</h4>
            <p>Are you sure you want to delete the record?</p>
        </div>
        <div class="modal-footer">

            <form method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <a href="#!" class="modal-close btn blue-grey lighten-2 waves-effect">No</a>
                <button type="submit" class="modal-close btn waves-effect red lighten-2">Yes</button>
            </form>
        </div>
    </div>
    <!-- /Delete Modal Structure -->
    <!--JQuery Library-->
    <script src="{{asset('js/jquery.min.js')}}" type="text/javascript"></script>
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="{{asset('js/materialize.min.js')}}"></script>
    <!--Include Page Level Scripts-->
    <script src="{{asset('js/pages/home.js')}}"></script>
</body>

</html>
