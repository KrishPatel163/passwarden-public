<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/main.css">
    <title>Home</title>
</head>

<body>
        <div id="nav">
            <div id="navright">
                <h2>Passwarden </h2>
            </div>
            <div id="navleft">
                <a href="">About</a>
                <a href="">Contact us</a>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit">Log Out</button>
                </form>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('welcome'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('welcome') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div id="main">
            <div id="modal">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Store
                    Password</button>
    
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Enter Credentials</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="/create-pass" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="website" class="col-form-label">Website:</label>
                                        <input type="text" class="form-control" name="website">
                                    </div>
                                    <div class="mb-3">
                                        <label for="accountName" class="col-form-label">Account Name:</label>
                                        <input type="text" class="form-control" name="account_name" id="accountName">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="col-form-label">Password:</label>
                                        <input type="text" class="form-control" name="password" id="inputPassword">
                                    </div>
                                    <hr class="border border-secondary w-100">
                                    <div class="mb-3">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Generate Password</h1>
                                        <label for="length" class="col-form-label">Length:</label>
                                        <input type="number" min="5" value="5" class="form-control" name="length" id="inputLength">
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary" id="generatePasswordButton"> Generate Strong Password </button>
                                        <button type="submit" class="btn btn-primary"> Store Password </button>
                                    </div>
                                </form>                            
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="line"></div>
    
            <div id="table">
                <table>
                    <th>Website</th>
                    <th>Account Name</th>
                    <th>Password</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                    @if ($count > 0)
                    @foreach ($data as $user)
                    <tr>
                        <td>{{ $user->website }}</td>
                        <td>{{ $user->account_name }}</td>
                        <td onclick="decryptAndCopy('{{ $user->password }}')" style="cursor: pointer">
                                    {{ substr($user->password, 0, 30) }}</td>
    
                        <td>{{ $user->created_at->format('d-m-y, h:i A') }}</td>
                        <td>{{ $user->updated_at->format('d-m-y, h:i A') }}</td>
                        <td class="inline">
                        <a href="/updating/{{ $user->id }}"><button type="submit"
                                            class="button">Update</button></a>
                        <a href="/deleteing/{{ $user->id }}"><button type="submit"
                                            class="button">Delete</button></a></td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">
                                <h4>No Saved Passwords</h4>
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
    
        </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
</script>
<script src="/home.js" defer></script>
</html>