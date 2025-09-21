<!doctype html>
<html lang="en">

<head>
    <title>LUPA PASSWORD</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
body {
  background: linear-gradient(135deg, #667eea, #764ba2);
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.container {
  background: #8d0c0cff;
  padding: 40px 30px;
  border-radius: 15px;
  text-align: center;
  width: 300px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

h1 {
  margin-bottom: 35px;
  color: #fff;
}

input {
  padding: 10px;
  width: 100%;
  border-radius: 8px;
  border: none;
  margin-bottom: 15px;
  text-align: center;
}

button {
  padding: 12px 25px;
  background: #667eea;
  border: none;
  border-radius: 10px;
  color: white;
  font-size: 15px;
  cursor: pointer;
  transition: 0.3s;
}

button:hover {
  background: #764ba2;
}
    </style>
</head>

<body>

<div class="container">
  <h1>Lupa Password</h1>
  <form id="resetForm" method="POST" action="/prosesreset">
    @csrf
    <input type="text" name="nik" id="nik" placeholder="Masukkan NIK" required>
    <button type="submit">Minta Reset Password</button>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            window.location.href = "{{ route('login') }}";
        });
    });
</script>
@endif



</body>
</html>
