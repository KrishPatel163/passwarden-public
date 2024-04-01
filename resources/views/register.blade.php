<x-LoginRegister>

    <div id="container">
        <form action="/register" method="post">
            @csrf
            <div class="form">
                <div class="form-header">
                    <h2>Register</h2>
                    <hr>
                </div>
                <div class="form-inp">
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Enter your name">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Enter your password">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_confirmation" placeholder="Confirm your password">
                    </div>
                    <div class="form-group">
                        <button type="submit">Register</button>
                    </div>
                </div>
                <hr>
                <div class="form-footer">
                    <a href="/">Login here</a>
                </div>
            </div>
        </form>
    </div>

    @if ($errors->any())
        <div id="error">
            <div class="err-content">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

</x-LoginRegister>
