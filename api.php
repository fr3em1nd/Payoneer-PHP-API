<?php
class Payoneer
{
  private $db;
  private $payee_details;
  private $payee_status=0;
  private $debugging;
    private $PartnerID = '<your partner ID>';
	private $Username = '<your payoneer username>';
	private $Password = '<your payoneer password';
	private $apiURL = 'https://api.payoneer.com/payouts/HttpAPI/API.aspx?';
  
  function __construct(&$db)
  {
    $this->db = &$db;
	$this->debugging = 0;
  }
  
  function get_string_between($string, $start, $end){
	$string = " ".$string;
	$ini = strpos($string,$start);
	if ($ini == 0) return "";
	$ini += strlen($start);
	$len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}
  
  function getMemSignupLink($memid)
  {
	$payeeid = 'tftm'.$memid;
	$url = $this->apiURL."mname=GetToken&p1=".$this->Username."&p2=".$this->Password."&p3=".$this->PartnerID."&p4=".$payeeid;
	
	$fh = fopen($url, 'r'); 
	$data = fread($fh, 1024); 
	fclose($fh);
	
	return $data;
  }
  
  function getVendorSignupLink($memid)
  {
	$payeeid = 'tftv'.$memid;
	$url = $this->apiURL."mname=GetToken&p1this->=".$Username."&p2=".$this->Password."&p3=".$this->PartnerID."&p4=".$payeeid;
	
	$fh = fopen($url, 'r'); 
	$data = fread($fh, 1024); 
	fclose($fh);
	
	return $data;
  }
  
  function getPayeeDetails($payeeid)
  {
	$url = $this->apiURL."mname=GetPayeeDetails&p1=".$this->Username."&p2=".$this->Password."&p3=".$this->PartnerID."&p4=".$payeeid;
	
	$fh = fopen($url, 'r'); 
	$data = fread($fh, 1024); 
	fclose($fh);
	
	$this->payee_details = $data;
	$this->payee_status = 1;
  
  }
  
  function checkCardStatus($payeeid)
  {
	if($this->payee_status != 1)
	{
		$this->getPayeeDetails($payeeid);
	}
	
	$word1 = '<CardStatus>';
	$word2 = '</CardStatus>';
	$between= $this->get_string_between($this->payee_details, $word1, $word2);

	return $between;
  }
  
  function checkCardActivation($payeeid)
  {
	if($this->payee_status != 1)
	{
		$this->getPayeeDetails($payeeid);
	}
	
	$word1 = '<ActivationStatus>';
	$word2 = '</ActivationStatus>';
	$between= $this->get_string_between($this->payee_details, $word1, $word2);

	return $between;
  }
 
}
?>
