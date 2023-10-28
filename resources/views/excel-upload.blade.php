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
    <div class="row mt20 mr10">
        <div class="col s12 right-align">
            <a class="btn waves-effect waves-light blue lighten-2" href="{{route('contacts.index')}}"> Home</a>
        </div>
    </div>
    <!-- /Index Page Link-->
    <div class="container">
        <div class="row">
            <h2>Upload File </h2>
        </div>
        <div class="row mt50">
            <form id="excel-upload-form" action="{{route('contacts.excel.import')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="file-field input-field">
                    <div class="btn">
                        <span>Choose File</span>
                        <input type="file" name="excel" accept=".xlsx">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" name="excel">
                        @error('excel')
                            <div class="excel_error red-text">{{"Please select a file to upload"}}</div>
                        @enderror
                    </div>

                </div>
                    <button class="btn waves-effect waves-light lighten-2 right" type="submit">Upload</button>
            </form>
        </div>
        @if (session()->get('status') === 'fail')
        <div>
            <p class="red-text">Failed to add some contacts. Download the file to view errors.</p>
            <a href="{{route('contacts.excel.export')}}" class="btn waves-effect waves-light lighten-2 left">Downlaod Error Report</a>
        </div>
        @endif
    </div>


    <!-- Footer -->
    <footer class="page-footer footer-fixed p0">
        <div class="footer-copyright ">
            <div class="container">
                <p class="center-align">© 2020 Study Link Classes</p>
            </div>
        </div>
    </footer>
    <!-- /Footer -->
    <!--JQuery Library-->
    <script src="{{asset('js/jquery.min.js')}}" type="text/javascript"></script>
    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="{{asset('js/materialize.min.js')}}"></script>
    <!--Include Page Level Scripts-->
    <script src="{{asset('js/pages/excel-upload.js')}}"></script>
</body>

</html>
