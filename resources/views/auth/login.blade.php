<x-layouts.front>
  <div class="login-form-container">
    <x-form 
      class="login-form"
      :tabs=false
      :inputs="[
        ['name' => 'email', 'type' => 'email', 'label' => 'Email', 'width' => 'full-width'],
        ['name' => 'password', 'type' => 'text', 'label' => 'Contraseña', 'width' => 'full-width']
      ]"
    />
    <div class="login-form-buttons">
      <a href="{{ route('password.request') }}">
        ¿Olvidaste tu contraseña?
      </a>
      <div class="login-button">
        <button>Iniciar sesión</button>
      </div>
    </div>
  </div>
</x-layouts.front>
