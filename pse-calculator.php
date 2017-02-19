<?php 
ini_set('display_errors', 1);//Show errors on browser
error_reporting(E_ALL);//Display all possible problems


//====================List of variables====================//

//Broker fee variables
$commission = 0.0025;//Commission of the gross trade amount
    /*Note: The commission fee has a minimum charge of Php 20 per transaction. If you require a broker-assisted trade, the commission charge is .5% of the Gross Trade Amount.*/
$psetf = 0.00005;//Philippine Stock Exchange Transaction Fee of the gross trade amount
$sccp = 0.0001;//Securities Clearing Corporation of the Philippines Fee of the gross trade amount

$vat = 0.12;//Value Added Tax of Commission

$salesTax = 0.005;//Sales Tax
/*Data Source:
https://www.colfinancial.com/ape/Final2/home/faq.asp as of 2017-02-19-01-42*/


//Form variables
$numberOfShares = $_POST['numberOfShares'];
$buyPrice = $_POST['buyPrice'];
$sellPrice = $_POST['sellPrice'];

//Other variables
// $commissionComputed;

//====================Computations====================//

$grossBuyAmount = $numberOfShares * $buyPrice;//Buy amount without fees

$grossSellAmount = $numberOfShares * $sellPrice;//Sell amount without fees


//Fees computation

//Buy fees
$rawCommission = $grossBuyAmount * $commission;//Commission for Gross Trade amount

if ($rawCommission > 19)
{
    $commissionComputed = $rawCommission;
} else 
{
    $commissionComputed = 20;
}//Commission adjusted according to rawCommission value. Commissions less than 20 are adjusted to 20


$vatComputed = $commissionComputed * $vat;//VAT computed from commission value

$pseTransactionFeeComputed = $grossBuyAmount * $psetf;//Computed Philippine Stocke Exchange Transaction Fee

$sccpComputed = $grossBuyAmount * $sccp;//SCCP fees computed from the gross trade amount

$totalBuyFee = $commissionComputed + $vatComputed + $pseTransactionFeeComputed + $sccpComputed;


//Sell Fees
$salesTaxComputed = $grossSellAmount * $salesTax;//Sales tax computed from gross sell amount

$totalSellFee = $totalBuyFee + $salesTax;//Total sell fee is total buy fees plus sales tax


//Net Amount Computation
$netBuyAmount = $grossBuyAmount + $totalBuyFee;//Net buy amount. Buy fees added
$netSellAmount = $grossSellAmount - $totalSellFee;//Net sell amount. Gross sell amount less total fees


//Profit or Loss Computation
$profitOrLoss = $netSellAmount - $netBuyAmount;//Profit displays positive value and loss with negative value
$profitOrLossPercentage = $profitOrLoss / $netBuyAmount * 100;//Profit or loss converted to percentage value


//====================Display results====================//

print 
"
<p>
    Fees and other computed values:<br>
    Gross buy amount: $grossBuyAmount<br>
    Gross sell amount: $grossSellAmount<br>
    Commission: $commissionComputed<br>
    VAT: $vatComputed<br>
    PSE transaction fee: $pseTransactionFeeComputed<br>
    SCCP: $sccpComputed<br>
    Total buy fee: $totalBuyFee<br>
    <br>
    Sales tax: $salesTaxComputed<br>
    Total sell fee: $totalSellFee
</p>
<p>
    Trade Results:<br>
    Net buy amount: $netBuyAmount<br>
    Net sell amount: $netSellAmount<br>
    Profit or loss: $profitOrLoss<br>
    Profit or loss percentage: $profitOrLossPercentage
</p>
"
;



?>