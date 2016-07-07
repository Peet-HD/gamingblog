<div class="loginform">
    <form action="{$urlHelper->url(['controller' => 'user', 'action' => 'login'])}" method="POST">
        <input type="email" placeholder="Username" required="true"></input>
        <input type="password" placeholder="Password" required="true"></input>
        <button type="submit">Login</button>
        <br>
      
    </form>
  <a href="">Registrieren</a>
  <a href="">Passwort vergessen?</a>
</div>