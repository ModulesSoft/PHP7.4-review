<?php

namespace app\models;

use app\Database;
use app\helpers\GeneralHelper;
use PDO;
use PDOException;

class Product
{
  public ?Database $db = null;

  public ?int $id = null;
  public string $title;
  public string $description;
  public float $price;
  public array $imageFile;
  public ?string $imagePath = null;

  public function __construct()
  {
    $this->db = new Database;
  }

  public function set($data)
  {
    $this->id = $data['id'] ?? null;
    $this->title = $data['title'];
    $this->description = $data['description'];
    $this->price = (float)$data['price'];
    $this->imageFile = $data['imageFile'];
    $this->imagePath = $data['image'] ?? null;
  }

  public function save()
  {
    //validation and submit query
    $errors = [];
    if (!$this->title) {
      $errors[] = "title must not be empty";
    }
    if (!$this->description) {
      $errors[] = "description must not be empty";
    }
    if (!$this->price) {
      $errors[] = "price must not be empty";
    }
    if (empty($errors)) {
      if (isset($this->imageFile) && $this->imageFile['name']) {
        if (!($this->imageFile['size'])) {
          die('image size is too heavy. maximum possible: 2MB');
        }
        if (!file_exists('uploads')) {
          mkdir('uploads', 0777, true);
        }
        //make unique name and path for image
        $ext = explode('.', $this->imageFile['name']);
        $extention = $ext[count($ext) - 1];
        $this->imagePath = 'uploads/' . GeneralHelper::randomName($extention);
        move_uploaded_file($this->imageFile['tmp_name'], $this->imagePath);
      }
      if ($this->id) {  //it's a product update
        $this->db->editProduct($this);
      } else {  //it's a new product
        $this->db->addProduct($this);
      }
    } else {
      return $errors;
    }
  }
}
