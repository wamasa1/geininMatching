@if (session($message))
  <div class="alert alert-success mt-1">
    {{ session($message) }}
  </div>
@endif