
<div class="login-form">
  <div class="form-validation">
    @if ($errors->any())
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    @endif
  </div>

  <form method="POST" action="{{ route('login') }}">
  
    @csrf
  
    <div class="form-elements">
      <div class="form-element full-width">
        <div class="form-element-label">
          <label for="email">Email</label>
        </div>
        <div class="form-element-input">
          <input type="email" name="email" id="email">
        </div>
      </div>
      <div class="form-element full-width">
        <div class="form-element-label">
          <label for="password">Contraseña</label>
        </div>
        <div class="form-element-input">
          <input type="password" name="password" id="password">
        </div>
      </div>
    </div>
    <div class="login-form-buttons">
      <a href="{{ route('password.request') }}">
        ¿Olvidaste tu contraseña?
      </a>
      <div class="login-button">
        <button>Iniciar sesión</button>
      </div>
    </div>
  </form>
</div>
