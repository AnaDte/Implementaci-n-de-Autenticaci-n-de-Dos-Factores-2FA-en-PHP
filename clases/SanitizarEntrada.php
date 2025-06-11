<?php
class SanitizarEntrada {

    public static function limpiarCadena(string $cadena): string {
        return trim(strip_tags($cadena));
    }
    
    // Convierte texto a mayúsculas y elimina espacios
    public static function convertirMayusculas(string $texto): string {
        return strtoupper(trim($texto));
    }

    // Verifica si el correo ya existe
    public static function correoExiste(mysqli $conn, string $correo): bool {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        return $count > 0;
    }

    // Verifica si el nombre de usuario ya existe
    public static function usuarioExiste(mysqli $conn, string $usuario): bool {
        $sql = "SELECT COUNT(*) FROM usuarios WHERE Usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        return $count > 0;
    }

    // Validaciones de contraseña
    public static function validarClave(string $clave): ?string {
    if (strlen($clave) < 8) {
        return "La contraseña debe tener al menos 8 caracteres.";
    } elseif (strlen($clave) > 12) {
        return "La contraseña no debe tener más de 12 caracteres.";
    }
    return null; // válida
    }

    // Validaciones de correo
    public static function validarCorreo(string $correo): ?string {
            $correo = trim($correo); // elimina espacios antes de validar
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return "Formato de correo inválido.";
        }
        return null; // válido
    }

    // Validaciones de nombre del usuario
    public static function validarNombre(string $nombre): ?string {
        if (empty($nombre)) {
            return "El nombre es obligatorio.";
        } elseif (!preg_match('/^[a-zA-Z\s]+$/', $nombre)) {
            return "El nombre solo puede contener letras y espacios.";
        }
        return null; // válido
    }

    // Validaciones de apellido del usuario
    public static function validarApellido(string $apellido): ?string {
        if (empty($apellido)) {
            return "El apellido es obligatorio.";
        } elseif (!preg_match('/^[a-zA-Z\s]+$/', $apellido)) {
            return "El apellido solo puede contener letras y espacios.";
        }
        return null; // válido
    }

    // Validaciones de usuario
    public static function validarUsuario(string $usuario): ?string {
    if (!preg_match('/^[a-zA-Z0-9]+$/', $usuario)) {
        return "El usuario solo puede contener letras y números.";
    }
    return null; // válido
}

}
?>