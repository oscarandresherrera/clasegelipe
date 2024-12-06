<?php
// Configuración de conexión a la base de datos
$host = 'localhost';
$dbname = 'pruebaeps';
$usuario = 'root';
$contraseña = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $contraseña);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("¡Error en la conexión a la base de datos!: " . $e->getMessage());
}

// Función para manejar el CRUD según la tabla
function manejarCRUD($pdo, $tabla, $accion, $datos) {
    switch ($tabla) {
        case 'Producto':
            manejarProducto($pdo, $accion, $datos);
            break;
        case 'Cliente':
            manejarCliente($pdo, $accion, $datos);
            break;
        case 'Factura':
            manejarFactura($pdo, $accion, $datos);
            break;
        default:
            echo "Tabla no válida.";
    }
}

// Manejo CRUD para la tabla Producto
function manejarProducto($pdo, $accion, $datos) {
    switch ($accion) {
        case 'create':
            $sql = "INSERT INTO Producto (nombre, lote) VALUES (:nombre, :lote)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['nombre' => $datos['nombre_producto'], 'lote' => $datos['lote']]);
            echo "Producto creado exitosamente.";
            break;
        case 'read':
            $stmt = $pdo->query("SELECT * FROM Producto");
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($productos as $producto) {
                echo "ID: {$producto['codigo']}, Nombre: {$producto['nombre']}, Lote: {$producto['lote']}<br>";
            }
            break;
        case 'update':
            $sql = "UPDATE Producto SET nombre = :nombre, lote = :lote WHERE codigo = :codigo";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['nombre' => $datos['nombre_producto'], 'lote' => $datos['lote'], 'codigo' => $datos['codigo']]);
            echo "Producto actualizado exitosamente.";
            break;
        case 'delete':
            $sql = "DELETE FROM Producto WHERE codigo = :codigo";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['codigo' => $datos['codigo']]);
            echo "Producto eliminado exitosamente.";
            break;
        default:
            echo "Acción no válida para Producto.";
    }
}

// Manejo CRUD para la tabla Cliente
function manejarCliente($pdo, $accion, $datos) {
    switch ($accion) {
        case 'create':
            // Insertar nuevo cliente y obtener su cliente_id
            $sql = "INSERT INTO Cliente (tipo_documento, numero_documento, nombre, apellido, telefono, fecha_nacimiento) 
                    VALUES (:tipo_documento, :numero_documento, :nombre, :apellido, :telefono, :fecha_nacimiento)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'tipo_documento' => $datos['tipo_documento'],
                'numero_documento' => $datos['numero_documento'],
                'nombre' => $datos['nombre'],
                'apellido' => $datos['apellido'],
                'telefono' => $datos['telefono'],
                'fecha_nacimiento' => $datos['fecha_nacimiento']
            ]);

            // Obtener el cliente_id (que es autoincremental)
            $cliente_id = $pdo->lastInsertId();
            
            echo "Cliente creado exitosamente. Cliente ID: $cliente_id";
            break;
        
        case 'read':
            // Leer todos los clientes, incluyendo el cliente_id
            $stmt = $pdo->query("SELECT * FROM Cliente");
            $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($clientes as $cliente) {
                echo "Cliente ID: {$cliente['cliente_id']}, Documento: {$cliente['numero_documento']}, Nombre: {$cliente['nombre']} {$cliente['apellido']}, Teléfono: {$cliente['telefono']}<br>";
            }
            break;
        
        case 'update':
            // Actualizar los datos del cliente
            $sql = "UPDATE Cliente SET nombre = :nombre, apellido = :apellido, telefono = :telefono, fecha_nacimiento = :fecha_nacimiento 
                    WHERE cliente_id = :cliente_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'nombre' => $datos['nombre'],
                'apellido' => $datos['apellido'],
                'telefono' => $datos['telefono'],
                'fecha_nacimiento' => $datos['fecha_nacimiento'],
                'cliente_id' => $datos['cliente_id']  // Usamos cliente_id como identificador
            ]);
            echo "Cliente actualizado exitosamente.";
            break;
        
        case 'delete':
            // Eliminar cliente
            $sql = "DELETE FROM Cliente WHERE cliente_id = :cliente_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['cliente_id' => $datos['cliente_id']]);
            echo "Cliente eliminado exitosamente.";
            break;
        
        default:
            echo "Acción no válida para Cliente.";
    }
}


// Manejo CRUD para la tabla Factura
function manejarFactura($pdo, $accion, $datos) {
    switch ($accion) {
        case 'create':
            $sql = "INSERT INTO Factura (cliente_id, producto_id, cantidad, valor) 
                    VALUES (:cliente_id, :producto_id, :cantidad, :valor)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'cliente_id' => $datos['cliente_id'],
                'producto_id' => $datos['producto_id'],
                'cantidad' => $datos['cantidad'],
                'valor' => $datos['valor']
            ]);
            echo "Factura creada exitosamente.";
            break;
        case 'read':
            $stmt = $pdo->query("SELECT * FROM Factura");
            $facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($facturas as $factura) {
                echo "Número: {$factura['numero_factura']}, Cliente: {$factura['cliente_id']}, Producto: {$factura['producto_id']}, Cantidad: {$factura['cantidad']}, Valor: {$factura['valor']}<br>";
            }
            break;
        case 'update':
            $sql = "UPDATE Factura SET cliente_id = :cliente_id, producto_id = :producto_id, cantidad = :cantidad, valor = :valor 
                    WHERE numero_factura = :numero_factura";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'cliente_id' => $datos['cliente_id'],
                'producto_id' => $datos['producto_id'],
                'cantidad' => $datos['cantidad'],
                'valor' => $datos['valor'],
                'numero_factura' => $datos['numero_factura']
            ]);
            echo "Factura actualizada exitosamente.";
            break;
        case 'delete':
            $sql = "DELETE FROM Factura WHERE numero_factura = :numero_factura";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['numero_factura' => $datos['numero_factura']]);
            echo "Factura eliminada exitosamente.";
            break;
        default:
            echo "Acción no válida para Factura.";
    }
}

// Procesar datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tabla = $_POST['tabla'] ?? '';
    $accion = $_POST['accion'] ?? '';
    manejarCRUD($pdo, $tabla, $accion, $_POST);
}
?>
