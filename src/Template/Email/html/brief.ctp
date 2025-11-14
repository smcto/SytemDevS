<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Trombinoscope</title>
<style>
p{ margin:0px; padding:0px;}
img{ border:none; display:block;}
</style>
</head>
<body>
<table cellpadding="0" cellspacing="0" align="center" width="1000px">
	<tr>
    	<td width="1000px">
        	<table cellpadding="0" cellspacing="0">
            	<tr>
                	<td width="1000px" height="51px" bgcolor="#f5f5f5"></td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0">
            	<tr>
                	<td width="200px" bgcolor="#f5f5f5"></td>
                	<td width="600px"  bgcolor="#ffffff" style="border:1px solid #dadada;">
                    	<table cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td height="27px"></td>
                            </tr>
                        </table>

                        <table cellpadding="0" cellspacing="0">
                        	<tr><td height="34px"></td></tr>
                        </table>
                        <table cellpadding="0" cellspacing="0">
                        	<tr>
                            	<td width="40px"></td>
                            	<td width="520px">
                                	<table cellpadding="0" cellspacing="0">
                                    	<tr>
                                        	<td>
                                            	<span style="font-size:17px; color:#000000; font-family:arial;">Bonjour,</span><br/><br/>
												
                                                <p style="font-size:13px; color:#000000; font-family:arial; line-height:normal;">Un client vient de remplir les formulaires briefing de l'évènement : <?php echo $evenement->nom_event; ?>.
                                                </p>
												<p style="font-size:13px; color:#000000; font-family:arial; line-height:normal;">Veuillez cliquer <a href="<?php 
													echo (($evenement && $_SERVER['SERVER_ADDR'] != '127.0.0.1' && strtolower($_SERVER['SERVER_ADDR']) != 'localhost') ? 'https://crm.konitys.fr/fr/evenements/briefs/'.$evenement->id : '#'); ?>">ici</a> pour voir les détails.</p>
												
                                            </td>
                                        </tr>
                                        <tr>
                                        	<td height="15px"></td>
                                        </tr>
                                       
                                        <tr>
                                        	<td height="15px"></td>
                                        </tr>
                                        <tr>
                                        	<td height="15px"></td>
                                        </tr>
                         
                                        <tr>
                                        	<td height="15px"></td>
                                        </tr>
                                        <tr>
                                        	<td><p style="font-size:13px; color:#000000; font-family:arial; line-height:normal;">Merci et cordialement <br /></p></td><br>
                                        </tr>
                                    </table>
                                </td>
                            	<td width="40px"></td>
                            </tr>
                        </table>
                        <table cellpadding="0" cellspacing="0">
                        	<tr><td height="125px" width="600px"></td></tr>
                        </table>
                        <table cellpadding="0" cellspacing="0" align="center">
                        	<tr>
                            	<td>
													 <?php 
														echo 
														$this->Html->image(
														$this->Url->build('/webroot/img/logo.png', ['fullBase'=>true,'alt' => 'logo', 'style' => 'display:block']));
													?>                             		
                            		<!-- <img src="images/logo-footer.jpg" alt="logo-footer" style="display:block;"  /> -->
                            	</td>
                            </tr>
                        </table>
                        <table cellpadding="0" cellspacing="0">
                        	<tr><td height="40px" width="600px"></td></tr>
                        </table>
                    </td>
                	<td width="200px" bgcolor="#f5f5f5"></td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0">
            	<tr>
                	<td height="51px" width="1000px" bgcolor="#f5f5f5"></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>