<?php
 //------------------ Handling POST requests -----------------------
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {	
                            //----------- POST Request - Save Header ----------------------
                            if(isset($_POST["send_enquiry"])) 
                            {
                                    $enq_name = $_POST["enq_name"];
                                    $enq_address1 = $_POST["enq_address1"];
                                    $enq_address2= $_POST["enq_address2"];
                                    $enq_phonenum = $_POST["enq_phonenum"];
                                    $enq_mail_add = $_POST["enq_mail_add"];
                                    $enq_mailbody = $_POST["enq_mailbody"];
                                    $to = $client->clientmailaddress;
                                    
                                    
                                    $enqbody = '<html>' . 
                                               '<body>' .
                                               '<p>' .
                                               str_replace('\n', '<br>', $enq_mailbody) . "<br>" . PHP_EOL . 
                                               '</p>' . 
                                               '<p>' . 
                                               $enq_name . '<br>' . PHP_EOL . 
                                               $enq_address1 . '<br>' . PHP_EOL . 
                                               $enq_address2 . '<br>' . PHP_EOL . 
                                               $enq_phonenum . '<br>' . PHP_EOL . 
                                               $enq_mail_add . 
                                               '</p>' . 
                                               '</body>' . 
                                               '</html>';
                                    
 
                                    
                                    $mail = new PHPMailer();
                                    
                                    $mail->isSMTP();                                      // Set mailer to use SMTP
                                    $mail->Host = "smtp.gmail.com";  // Specify main and backup SMTP servers
                                    $mail->SMTPAuth = true;                               // Enable SMTP authentication
                                    $mail->Username = 'bishwaroop.mukherjee@gmail.com';                 // SMTP username
                                    $mail->Password = 'JAGANATH';                           // SMTP password
                                    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
                                    $mail->Port = 465;    
                                    $mail->Priority = 1;

                                    $mail->setFrom($enq_mail_add);
                                    $mail->addAddress($to);     // Add a recipient
                                    $mail->addReplyTo($enq_mail_add);
                                                                        
                                    $mail->isHTML(TRUE);

                                    $mail->Subject = 'Enquiry from '.$enq_name;
                                    $mail->Body    = $enqbody;
                                    $mail->AltBody = $enqbody;
                                    
                                    if(!$mail->Send()) {
                                    echo 'Message was not sent.';
                                    echo 'Mailer error: ' . $mail->ErrorInfo;
                                    } else {
                                    echo 'Message has been sent.';
                                    }
                            }
                    }
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

