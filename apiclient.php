<?php
require 'config.php';
require 'vendor/autoload.php';
require 'src/Odoo/OdooReader.php';

use OpenSPP\Odoo\OdooReader;

$client = new OdooReader($url, $database, $user, $password);

//print_r($client->version());

// Define the model to interact with
$model = 'g2p.entitlement';

// Define a valid domain filter if needed
// Example: To filter and get entitlements that are cash-based
$domain = array(array('is_cash_entitlement', '=', true));
// If no filter is needed, you can leave the domain array empty
// $domain = array();

// Define the fields to retrieve    
$fields = array('name', 'code', 'partner_id', 'company_id', 'cycle_id', 'program_id', 'valid_from', 'valid_until', 'is_cash_entitlement', 'currency_id', 'initial_amount', 'transfer_fee', 'balance', 'journal_id', 'disbursement_id', 'service_fee_disbursement_id', 'date_approved', 'state');

try {
    // Perform a search_read to get the records
    $records = $client->searchRead($model, $domain, $fields, 0, 5);

    // Print the retrieved records
    //print "<pre>";
    //print_r($records);
    //print "</pre>";
} catch (Exception $e) {
    // Handle the exception
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odoo XMLRPC PHP Client</title>
</head>

<body>

    <table border="1">
        <thead>
            <tr>
                <?php foreach ($fields as $field) : ?>
                    <th><b><?php echo ucwords(str_replace('_', ' ', $field)); ?></b></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($records as $record) : ?>
                <tr>
                    <?php foreach ($fields as $field) : ?>
                        <td>
                            <?php
                            if (is_array($record[$field])) {
                                echo $record[$field][1];  // Assuming the second element is the display value
                            } else {
                                echo $record[$field];
                            }
                            ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>