<?php
require_once '../DB/db_conn.php';
include_once('./fpdf186/fpdf.php');

session_start(); // Start session if not already started

// Creating PDF class that extends FPDF class
class PDF extends FPDF
{
    protected $pdo;
    protected $userID;

    public function __construct()
    {
        parent::__construct(); // Call the parent constructor

        $db = new Database();
        $this->pdo = $db->getConnection();

        // Set the userID from session if available
        if (isset($_SESSION["UserId"])) {
            $this->userID = filter_var($_SESSION["UserId"], FILTER_VALIDATE_INT);
        }
    }

    public function getPDO()
    {
        return $this->pdo;
    }

    public function getUserID()
    {
        return $this->userID;
    }

    // Coding for the header section
    function Header()
    {
        $this->Image('./image/logo.png', 94, 5, 25);
        $this->SetFont('Arial', 'B', 23);
        $this->Ln(20);
        $this->Cell(0, 10, 'RAMT Coffee', 0, 0, 'C');
        $this->Ln(20);
    }

    // Coding for the footer section
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

// Create the object of PDF class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

$sql = "SELECT * 
        FROM Users 
        WHERE UserID = :UserID";
$stmt = $pdf->getPDO()->prepare($sql);
$stmt->execute([':UserID' => $pdf->getUserID()]);

if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Cell(40, 10, "Customer Name:", 0);
    $pdf->Cell(80, 10, $row['FirstName'] . " " . $row['LastName'], 0, 0, 'L');
    $pdf->Cell(32, 10, "Date:", 0, 0, 'R');
    $currentDate = date("M d, Y");
    $pdf->Cell(30, 10, $currentDate, 0, 0, 'R');
    $pdf->Ln(8);
    
    $pdf->Ln(20);
    $pdf->SetFillColor(208, 217, 247);
    $pdf->Cell(100, 10, "Product", 1, 0, 'L', true);
    $pdf->Cell(30, 10, "Price", 1, 0, 'C', true);
    $pdf->Cell(30, 10, "Quantity", 1, 0, 'C', true);
    $pdf->Cell(30, 10, "Amount", 1, 0, 'C', true);
    $pdf->Ln(10);
}

$sql = "SELECT Cart.ProductID, Cart.Quantity, Cart.Price, Products.ProductName, Products.ImageURL 
        FROM Cart 
        JOIN Products ON Cart.ProductID = Products.ProductID
        WHERE Cart.UserID = :UserID";
$stmt = $pdf->getPDO()->prepare($sql);
$stmt->execute([':UserID' => $pdf->getUserID()]);

// Initialize total
$total = 0;

// Add products to the PDF
$pdf->SetFont('Arial', '', 12);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $amount = number_format($row['Quantity']) * number_format($row['Price'], 2);
    $total += $amount; // Accumulate the total

    // Displaying the product details
    $pdf->Cell(100, 10, $row['ProductName'], 'LR', 0);
    $pdf->Cell(30, 10, number_format($row['Price'], 2), 'LR', 0, 'C');
    $pdf->Cell(30, 10, number_format($row['Quantity']), 'LR', 0, 'C');
    $pdf->Cell(30, 10, number_format($amount, 2), 'LR', 0, 'C');
    $pdf->Ln();
    
    
}

$pdf->Cell(100, 10, '', 'LRB'); 
$pdf->Cell(30, 10, '', 'LRB'); 
$pdf->Cell(30, 10, '', 'LRB'); 
$pdf->Cell(30, 10, '', 'LRB'); 


$pdf->Ln(); // Move to the next line

// Calculate tax and grand total
$taxRate = 0.13; // 13% tax
$tax = $total * $taxRate;
$grandTotal = $total + $tax;

// Display total, tax, and grand total
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 10, "", 0, 0, 'C');
$pdf->Cell(30, 10, "", 0, 0, 'C');
$pdf->Cell(30, 10, 'Subtotal:', 'B', 0, 'R');
$pdf->Cell(30, 10, number_format($total, 2), 'B', 0, 'C');
$pdf->Ln();
$pdf->Cell(100, 10, "", 0, 0, 'C');
$pdf->Cell(30, 10, "", 0, 0, 'C');
$pdf->Cell(30, 10, 'Tax (13%):', 'B', 0, 'R');
$pdf->Cell(30, 10, number_format($tax, 2), 'B', 0, 'C');
$pdf->Ln();
$pdf->Cell(100, 10, "", 0, 0, 'C');
$pdf->Cell(30, 10, "", 0, 0, 'C');
$pdf->Cell(30, 10, 'Grand Total:', 'B', 0, 'R');
$pdf->Cell(30, 10, number_format($grandTotal, 2), 'B', 0, 'C');

$pdf->Ln(30);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(122, 10, "", 0, 0, 'L');

$sql = "DELETE FROM Cart WHERE UserID = :UserID";
$stmt = $pdf->getPDO()->prepare($sql);
$stmt->execute([':UserID' => $pdf->getUserID()]);
// Output data to the PDF file
$pdf->Output();


?>
