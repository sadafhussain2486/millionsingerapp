<?php
$message='<!DOCTYPE html >
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Change Password Email</title>
    </head>

    <body style="padding:0px;">
        <center>
            <table  align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#FAFAFA" style="padding:0px;">
            <tr>
            <td valign="top">
            <table align="center" width="100%">
                <tr>
                  <td align="center" valign="top" id="bodyCellTop" style="font-size:10px; line-height:125%; font-family: Arial,Helvetica,sans-serif; background-color:#ffffff;">
                        <table width="600" border="0" cellpadding="0" cellspacing="0" id="templateContainer" style=" max-width:600px;" >
                            <tr>
                                <td class="topbar topbar-center" valign="top" width="600" height="70" style="line-height: 125%; text-align:center;">
                                
                                        <img  width="200" src="http://eb01.com.hk/mit/web/assets/f45111d2/dist/img/login-logo.png" style="width: 85px !important; height:120x;" />
                                </td>                               
                            <tr>
                         </table>
                    </td>
                </tr>
                <tr>
                  <td align="center" valign="top" id="bodyCellTop2" width="100%" height="35" bgcolor="#FFFFFF" style="background-color:#FFFFFF !important; padding:0px;">
                        <table border="0" cellpadding="0" cellspacing="0" id="templateContainer" style="border:0px; width:600px;" >
                            <tr class="menu">
                                <td style="text-align: center;padding: 10px 0px;color:#163758;font-size: 30px;letter-spacing: 2px;">
                                        MIT Target
                                </td>
                            </tr>
                         </table>
                    </td>
                </tr>         
              
                <tr class="heading">
                    <td align="center" valign="top" id="preview" bgcolor="#FFFFFF" style="background-color:#FFFFFF; padding:0px;">
                        <table cellpadding="0" cellspacing="0" border="0" >
                            <tr>
                                <td bgcolor="#ffffff" width="600"  valign="top" style="padding-top:5px; padding-bottom:5px;border-top: 3px solid #163758;border-bottom: 3px solid #163758;">
                                <img  width="600" height="250" src="http://eb01.com.hk/mit/web/assets/f45111d2/dist/img/banner.png" style="max-width:600px; display:block;height: 135px;object-fit: cover;" />
                                
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr >
                    <td align="center" valign="top" id="bodyCell" bgcolor="#FFFFFF" style=" background-color:#FFFFFF; font-family: Arial, Helvetica, sans-serif; color:#505050; font-size:14px;">
                        <table border="0" cellpadding="0" cellspacing="0" id="templateContainer" style="width:600px; border-collapse:collapse;">
                        
                            <!-- // Start Line with the Title  -->
                            <tr class="titleline">
                                <td align="left" class="bodyContent10px" valign="middle" width="100%" height="21" style=" padding:10px; padding-top:30px; padding-bottom:0px;">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" height="1">
                                        <tr>
                                            <td valign="top" mc:edit="new_products_2_columns" style="width:100%; padding-bottom:3px; color: #383838; font-size: 20px; font-style: italic; font-weight:normal; font-family:Georgia, "Times New Roman", Times, serif; border-bottom:1px solid #ECECEA; text-align:center;">
                                                
                                                  <singleline label="New Products">Change Password Mail</singleline> 
                                               
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>                        
                            <repeater>  
                            <tr class="content_msg">
                                <td align="center" valign="top" style="padding-bottom:20px;">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateBody">
                                        <tr mc:repeatable>
                                            <td valign="top" class="bodyContent" style="padding-top:30px; padding-left:10px; padding-right:10px; padding-bottom:20px; text-align:left;">
                                                <singleline label="Slogan One"><strong>Dear '.$username.',</strong>
                                                <br>
                                                <br>
                                                <span style="line-height:20px;">Request for email change.<br><br> Your OTP Code is: '.$otpcode.'</span>
                                                </singleline>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                 
                                </td>
                            </tr>
                            </repeater>   
                        </table>
                    </td> 
              </tr>   
              <tr>
                <td id="bodyCellFooter" valign="top" class="bodyCellFooterSecond" align="center" style="background-color:#163758; ">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer" style="max-width:600px;">
                        <tr>
                            <td valign="top" class="footerContent2" style="text-align:center; padding:10px; color:#b2b2b2; font-family: Arial, Helvetica, sans-serif; font-size:12px; line-height:150%;" mc:edit="footer_content02">
                                                © MotiF Inc. Tech Limited - All rights reserved
                             </td>
                         </tr>
                     </table>
                  </td>
              </tr>             
            </table>
            </td>
            </tr>
           </table>
        </center>
    </body>
</html>';