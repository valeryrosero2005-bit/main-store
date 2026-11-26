SELECT 
    id as user_id,
    ident_number as cedula,
    lastname,
    firstname,
    email,
    status,
    url_photo
    from 
        users
where
    mobile_phone is not null and 
    status = true
    order by 
        lastname ASC;
        --ALTER SEQUENCE users_id_seq RESTART WITH 1;
        --DELETE FROM users WHERE id= 4

CREATE TABLE IF NOT EXISTS productos (
    id SERIAL PRIMARY KEY,
    sku VARCHAR(20) UNIQUE NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 10,
    colores VARCHAR(255) DEFAULT 'Negro,Blanco,Beige',
    tallas VARCHAR(100) DEFAULT 'S,M,L,XL',
    tienda VARCHAR(100) DEFAULT 'Ropa Store',
    sucursal VARCHAR(100) DEFAULT 'Sucursal Centro',
    foto_url TEXT,
    visible BOOLEAN DEFAULT true
);

INSERT INTO productos (sku, nombre, descripcion, precio, stock, colores, tallas, foto_url) VALUES
('ROP-001','Chaqueta','Chaqueta abrigada ideal para clima frío.',198000,12,'Negro,Beige,Café','S,M,L,XL','https://ejemplo.com/chaqueta.jpg'),
('ROP-002','Buzo','Buzo cómodo en algodón.',129000,20,'Negro,Blanco,Gris','S,M,L,XL','https://ejemplo.com/buzo.jpg'),
('ROP-003','Camiseta','Camiseta básica en algodón.',79000,25,'Blanco,Negro,Beige','S,M,L,XL','https://ejemplo.com/camiseta.jpg'),
('ROP-004','Pantalón','Pantalón casual.',149000,15,'Negro,Azul,Beige','S,M,L,XL','https://ejemplo.com/pantalon.jpg'),
('ROP-005','Gorra','Gorra ajustable.',59000,30,'Negro,Blanco,Rojo','Única','https://ejemplo.com/gorra.jpg'),
('ROP-006','Falda','Falda casual.',89000,10,'Negro,Beige','S,M,L','https://ejemplo.com/falda.jpg');



//CREAR LAS CATEGORIAS 
ALTER TABLE productos ADD COLUMN IF NOT EXISTS categoria VARCHAR(100);
ALTER TABLE productos ADD COLUMN IF NOT EXISTS imagen VARCHAR(255);
ALTER TABLE productos ADD COLUMN IF NOT EXISTS foto VARCHAR(255);

//GUARDAR MIS PEDIDIOS PARA LOS USURIOS 
CREATE TABLE IF NOT EXISTS pedidos (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id),
    total DECIMAL(10,2) NOT NULL,
    nombre_cliente VARCHAR(100),
    direccion TEXT,
    telefono VARCHAR(20),
    metodo_pago VARCHAR(50),
    estado VARCHAR(20) DEFAULT 'pendiente',
    fecha TIMESTAMP DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS pedido_detalle (
    id SERIAL PRIMARY KEY,
    pedido_id INT REFERENCES pedidos(id) ON DELETE CASCADE,
    producto_id INT REFERENCES productos(id),
    nombre VARCHAR(100),
    precio DECIMAL(10,2),
    cantidad INT,
    color VARCHAR(50),
    talla VARCHAR(10)
);

//PARA MIRAR QUIEN ES USUARIO Y QUIEN ADMIN
SELECT id, firstname, lastname, email, rol FROM users ORDER BY id;
// MIRAR QUE TABLAS TENGO 
SELECT column_name FROM information_schema.columns WHERE table_name = 'users';
 
UPDATE users SET rol = 'admin' WHERE email = 'UPDATE users SET rol = 'admin' WHERE email = 'valery@gmail.com';
UPDATE users SET rol = 'admin' WHERE email = 'v@gmail.com';
SELECT firstname, email, rol FROM users;