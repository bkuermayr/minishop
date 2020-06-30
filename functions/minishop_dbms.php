<?php 
/** 
 *  The class MinishopDBMS implements functionality for onlineshop database actions 
 *  This version implements the creating, editing and organizing of articles. Usermanagement may be added it future versions
 * 
 *  @author Benjamin Kuermayr
 *  @version 2020-04-22
*/
class MinishopDBMS {
    public $db;

    /**
     * establishes db connection
     */
    public function setup($host,$dbname,$user,$password) {
        //connection string
        $dcs = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        
        $options = array(
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        );

        try {
            //connect to db
            $this->db = new PDO($dcs,$user,$password,$options);
            $this->db->exec("
                -- Nutzerdaten
                CREATE TABLE users (
                id_user INTEGER NOT NULL AUTO_INCREMENT,
                fullname VARCHAR(100),
                username VARCHAR(30),
                email VARCHAR(254) NOT NULL,
                birthdate DATE,
                gender VARCHAR(10),
                password_hash VARCHAR(255),
                userrole VARCHAR(50),
                PRIMARY KEY (id_user)
                );

                -- Produktdaten
                CREATE TABLE products (
                id_product INTEGER NOT NULL AUTO_INCREMENT,
                title VARCHAR(255) NOT NULL,
                description_long TEXT,
                description_short VARCHAR(255),
                unitprice DECIMAL(6,2) NOT NULL,
                unit VARCHAR(30),
                productweight INTEGER,
                quantity INTEGER NOT NULL,
                createdBy INTEGER,
                PRIMARY KEY (id_product),
                FOREIGN KEY (createdBy)
                REFERENCES users (id_user)
                );

                -- Produktbilder
                CREATE TABLE product_images ( 
                imagename VARCHAR(300) NOT NULL,
                id_product INTEGER,
                PRIMARY KEY (imagename,id_product),
                FOREIGN KEY (id_product)
                REFERENCES products (id_product)
                ON DELETE CASCADE
                );
        ");

        } catch (PDOException $e) {
            //echo $e->getMessage();
        }
    }

    /**
     * fetches all articles out of db
     * @return result the articles as array
     */
    public function getArticles() {
        try {
            $stmt = $this->db->prepare("SELECT * FROM products;");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $result = array();
            while($row = $stmt->fetch()) {
                $row['images']=$this->getImages($row['id_product']);
                $result[]=$row;
            }
            $stmt = null;

            return $result;
        }   catch (PDOException $e) {
            //echo $e->getMessage();
        }
    }

    /**
     * gets a specific article
     * @param id a specific article id
     * @return result the article as array
     */
    public function getArticle($id) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM products WHERE id_product=:id;");
            $stmt->bindParam(":id",$id);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            $result = $stmt->fetch();
            $result['images']=$this->getImages($result['id_product']);
            $stmt = null;

            return $result;

        }   catch (PDOException $e) {
            //echo $e->getMessage();
        }
    }

    /**
     * fetches all product images for specified article
     * @param pid the articleid/productid
     * @return result the article as array
     */
    public function getImages($pid) {
        if($pid != null) {
            try {
                $stmt = $this->db->prepare("SELECT imagename FROM product_images WHERE id_product=:pid;");
                $stmt->bindParam(":pid",$pid);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);

                $result = array();
                while($row = $stmt->fetch()) {
                    $result[]=$row['imagename'];
                }

                $stmt = null;

                return $result;
            }   catch (PDOException $e) {
                //echo $e->getMessage();
            }
        }
    }

    /**
     * creates a new article/product in the db
     * @param data the data passed for the new article
     */
    public function createProduct($data) {
        $images = $data['images'];

        unset($data['images']);
        try {
            $stmt = $this->db->prepare("INSERT INTO products VALUES (null,:title,:description_long,:description_short,:unitprice,:unit,:productweight,:quantity,:createdBy);");
            $stmt->execute($data);
            $result = $this->db->lastInsertId();
            $stmt = null;               
            
            foreach($images as $imagename) {
                $this->addImage($result,$imagename);
            }    
            
            return $result;
        }   catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Removes a specified product from the db
     * @param id_product the productid
     */
    public function removeProduct($id_product) {
        try {
            $stmt = $this->db->prepare("DELETE FROM products WHERE id_product=:id_product;");
            $stmt->bindParam(":id_product",$id_product);


            $stmt->execute();
            $stmt = null;                               
        }   catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * updates Data for an edited product
     * @param data the newly updated data to be saved in the db
     */
    public function updateProduct($data) {
        $images = $data['images'];
        $this->removeImage($data['id_product']);
        foreach($images as $imagename) {
            $this->addImage($data['id_product'],$imagename);
        }    

        try {
            $stmt = $this->db->prepare("UPDATE products SET title=:title,description_long=:description_long,description_short=:description_short,unitprice=:unitprice,unit=:unit,productweight=:productweight,quantity=:quantity WHERE id_product=:id_product;");
            $data = array(
                ":title" => $data['title'],
                ":description_long" => $data['description_long'],
                ":description_short" => $data['description_short'],
                ":unitprice" => $data['unitprice'],
                ":unit" => $data['unit'],
                ":productweight" => $data['productweight'],
                ":quantity" => $data['quantity'],
                ":id_product" => $data['id_product']
            );
            $stmt->execute($data);
            $stmt = null;                               
        }   catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * adds an product image for a specified product
     * @param id_product the specified id
     * @param imagename the filename with extension (e.g.: landscapeMountains.jpg)
     */
    public function addImage($id_product,$imagename) {
        try {
            $stmt = $this->db->prepare("INSERT INTO product_images VALUES (:imagename,:id_product);");
            $stmt->bindParam(":imagename",$imagename);
            $stmt->bindParam(":id_product",$id_product);
            $stmt->execute();
            $stmt = null;                               
        }   catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /** 
     * Deletes all images for a specified product
     * @param id_product the specified product
    */
    public function removeImage($id_product) {
        try {
            $stmt = $this->db->prepare("DELETE FROM product_images WHERE id_product=:id;");
            $stmt->bindParam(":id",$id_product);
            $stmt->execute();
            $stmt = null;                               
        }   catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * closes database connection
     */
    public function close() {
        $this->db = null;
    }

    public function __construct($host,$dbname,$user,$password) {
        $this->setup($host,$dbname,$user,$password);
    }
}
?>