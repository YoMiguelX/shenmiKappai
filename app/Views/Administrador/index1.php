<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>CRUD con PHP y Tailwind</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-lg">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Gestión de Usuarios</h1>

    <!-- Formulario para crear nuevo usuario -->
    <form action="create.php" method="POST" class="flex flex-col md:flex-row gap-4 mb-6">
      <input type="text" name="name" placeholder="Nombre" class="border border-gray-300 p-2 rounded-md w-full" required>
      <input type="email" name="email" placeholder="Correo" class="border border-gray-300 p-2 rounded-md w-full" required>
      <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Agregar</button>
    </form>

    <!-- Tabla de usuarios -->
    <div class="overflow-x-auto">
      <table class="min-w-full border text-sm">
        <thead class="bg-gray-200 text-gray-700 uppercase text-xs">
          <tr>
            <th class="py-3 px-4 border">ID</th>
            <th class="py-3 px-4 border">Nombre</th>
            <th class="py-3 px-4 border">Correo</th>
            <th class="py-3 px-4 border text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $result = $conn->query("SELECT * FROM users");
          while ($row = $result->fetch_assoc()):
          ?>
          <tr class="hover:bg-gray-100">
            <td class="py-2 px-4 border"><?php echo $row['id']; ?></td>
            <td class="py-2 px-4 border"><?php echo $row['name']; ?></td>
            <td class="py-2 px-4 border"><?php echo $row['email']; ?></td>
            <td class="py-2 px-4 border text-center">
              <a href="update.php?id=<?php echo $row['id']; ?>" class="text-blue-500 hover:underline mr-3">Editar</a>
              <a href="delete.php?id=<?php echo $row['id']; ?>" class="text-red-500 hover:underline" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>

