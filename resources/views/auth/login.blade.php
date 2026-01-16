<h3>Login</h3>

<form method ="POST" action="/login">
    @csrf

    <input type="text" name="username" placeholder="Username" required>
    <br><br>

    <input type="password" name="password" placeholder="Password" required>
    <br><br>

    <button>Login</button>
</form>