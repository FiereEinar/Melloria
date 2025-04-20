<?php
require_once __DIR__ . '/vendor/autoload.php';
require 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $mpdf = new \Mpdf\Mpdf();
  header('Content-Type: application/pdf');

  $stmt = $pdo->prepare('SELECT * FROM products');
  $stmt->execute();
  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $count = 1;
  $productsLength = sizeof($products);

  $productList = '';
  foreach ($products as $product) {
    $productList .= '<tr>';
    $productList .= '<td>' . $count . '</td>';
    $productList .= '<td>' . $product['name'] . '</td>';
    $productList .= '<td>' . $product['category'] . '</td>';
    $productList .= '<td> P' . $product['price'] . '</td>';
    $productList .= '<td>' . $product['stock'] . '</td>';
    $productList .= '</tr>';
    $count++;
  }

  $html = '<!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sample PDF Output</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        margin: 20px;
      }

      h1 {
        text-align: center;
      }

      table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
      }

      th, td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
      }

      th {
        background-color: #f2f2f2;
      }
    </style>
  </head>
  <body>
    <h1>Product List</h1>
    <table>
      <thead>
        <tr>
          <th>No.</th>
          <th>Name</th>
          <th>Category</th>
          <th>Price</th>
          <th>Stock</th>
        </tr>
      </thead>
      <tbody>
        ' . $productList . '
      </tbody>
    </table>
  </body>
  </html>';

  $mpdf->WriteHTML($html);
  $mpdf->Output();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sample PDF Output</title>
  <link rel="stylesheet" href="./styles/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="styles/styles.css" />
</head>

<body>
  <form action="sample-print.php" method="POST">
    <button class="btn btn-primary" type="submit">Print</button>
  </form>
</body>

</html>