<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.12.1/datatables.min.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.12.1/datatables.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/test.js') }}"></script>
</head>
<style>
    .nav-link:hover {
        color: #fff !important;
        background-color: red;
    }

    .navbar {
        padding: 0 !important;
    }

</style>

<body>
    <div class="container-fluid">
        <div class="wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light ">
                <div class="container-fluid">
                    <a href="#" class="navbar-brand">
                        <img src="{{ asset('images/logo3.PNG') }}" height="28" alt="CoolBrand">
                    </a>
                    <button type="button" class="navbar-toggler" data-bs-toggle="collapse"
                        data-bs-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="navbar-nav">
                            <a href="{{ route('products') }}" class="nav-item nav-link ">Sản phẩm</a>
                            <a href="{{ route('customers') }}" class="nav-item nav-link">Khách hàng</a>
                            <a href="{{ route('users') }}" class="nav-item nav-link">Users</a>

                        </div>

                    </div>
                    <div class="float-right dropdown">
                        <a href="#" class="nva-item nav-link dropdown-toggle" id="navbardrop" data-toggle="dropdown"><i
                                class="fa-solid fa-circle-user" style="font-size: 25px"></i> Admin</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" data-toggle="modal" data-target="#myModal6" href="#">Đổi mật
                                khẩu</a>
                            <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                        </div>

                    </div>
                </div>
            </nav>
        </div>
        @yield('content')
    </div>
</body>
<div class="modal" id="myModal6">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Đổi mật khẩu</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('changePassword') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="pwd">Mật khẩu cũ:</label>
                        <input type="password" class="form-control" id="pwd" name="old_password">
                        {{-- @if ($errors->has('old_password'))
                            <span class="text-danger">{{ $errors->first('old_password') }}</span>
                        @endif --}}
                    </div>
                    <div class="form-group">
                        <label for="pwd">Mật khẩu mới:</label>
                        <input type="password" class="form-control" id="pwd" name="new_password">
                        {{-- @if ($errors->has('new_password'))
                            <span class="text-danger">{{ $errors->first('new_password') }}</span>
                        @endif --}}
                    </div>
                    <div class="form-group">
                        <label for="pwd">Nhập lại mật khẩu mới:</label>
                        <input type="password" class="form-control" id="pwd" name="new_password_confirmation">
                        {{-- @if ($errors->has('new_password_confirmation'))
                            <span class="text-danger">{{ $errors->first('new_password_confirmation') }}</span>
                        @endif --}}
                    </div>
                    <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

</html>
