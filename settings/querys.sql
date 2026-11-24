SELECT 
    id as user_id,
    ident_number as cedula,
    lastname,
    firstname,
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