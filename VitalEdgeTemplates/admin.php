<?php 
    use \VitalEdgeInc\VeApi\VePixelApi;
    $vitaledge = new VePixelApi();
    $showError = false;
    if ($_GET) {    
        if (isset($_POST['submit'])) {
            $postPixelId = sanitize_text_field( $_POST['ve-pixelid'] );
            $savePixelRes = $vitaledge->savePixel($postPixelId);
            if (isset($savePixelRes)){
                $pixel = $savePixelRes->data->pixel;
            }else{
                $showError = true;
            }
        }
    }

	$installRes = $vitaledge->getInstallation();
    $pixelId = $installRes->data->pixelId;
    $pixel;
    if(isset($pixelId) && $pixelId != 'null'){
        $pixelRes = $vitaledge->getPixel($pixelId);
        $pixel = $pixelRes->data;
    }
?>
<div class="ve-pagewrapper">
    <div class="ve-header">
        <div>
            <img src=<?php echo plugin_dir_url( __DIR__ )."assets/images/logo-vitaledge.svg" ?> style="width: 32px; padding-right: 10px;">
        </div>
        <div class="my-auto">VitalEdge Pixel</div>
    </div>
    <?php 
        if(isset($pixelId) && $pixelId != 'null'){
            $installedAt = $installRes->data->installedAt;
            echo '
            <div class="ve-content ve-detailswrp">
                <div class="ve-detailsheader">
                    VitalEdge Pixel Integration Details
                </div>
                <table style="margin-top: 13px">
                    <tr>
                        <td class="ve-label">VitalEdge Pixel ID:</td>
                        <td class="ve-value">'.$pixel->id.'</td>
                    </tr>
                    <tr>
                        <td class="ve-label">Wordpress Site:</td>
                        <td class="ve-value">'.$pixel->domainURL.'</td>
                    </tr>
                    <tr>
                        <td class="ve-label">Date of Installation</td>
                        <td class="ve-value">'.$installedAt.'</td>
                    </tr>
                </table>
            </div>';
        }
    ?>
    <!-- if has pixel -->
    
    <div class="ve-content">
        Paste the VitalEdge Pixel ID here: 
        <?php 
            if(isset($pixelId) && $pixelId != 'null'){
                echo '<form  method="post" style="display:inline-block;">
                    <input class="ve-input" type="text" onkeyup="success()" name="ve-pixelid" id="ve-pixelid">
                    <input type="button" class="ve-btn install-btn"id="submit-btn" onclick="openModal()" style="display: inline-block;" value="Install New Pixel"
                    disabled>
                    
                    <div id="warning-modal" class="modal">
                        <div style="display:flex; height: 100%; width: 100%;">
                            <div class="container">

                                <div class="modal-text">You are about to install a new VitalEdge Pixel in this site.</div>
                                <div class="modal-text">Captures from the previous VitalEdge Pixel will remain the same. </div>

                                <div class="clearfix">
                                    <button type="button" onclick="closeModal()" class="cancelbtn">Cancel</button>
                                    <button type="submit" name="submit" onclick="closeModal()" class="submitbtn">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>';
            
            }else{
                echo '<form  method="post" style="display:inline-block;">
                    <input class="ve-input" type="text" onkeyup="success()" name="ve-pixelid" id="ve-pixelid">
                    <button class="ve-btn install-btn" name="submit" type="submit" id="submit-btn" disabled>
                        Install Pixel
                    </button>
                </form>';
            }
        ?>

        <div>
        <?php
            if ($showError) {
                echo '<div class="ve-errortext" style="margin-top: 20px; width: 600px;">The Pixel ID you entered is invalid. Please provide a valid VitalEdge Pixel ID.
                You can login to your VitalEdge account to create or select an existing pixel
                and click the WordPress button to copy the VitalEdge Pixel ID.</div>';
            }
            
        ?>

               
       
        <div class="ve-smdesc" style="margin: 20px 0 20px;">
            To get the VitalEdge Pixel ID, go to the pixel you created in VitalEdge and click the WordPress button in Integrations.
        </div>

        </div>
        <div style="margin-top: 20px;">
            Don’t have a VitalEdge account yet? <a class="ve-links" href="https://app.vitaledge.io/auth/register">Click here to create a VitalEdge Account</a>
        </div>
    </div>
<div>

<?php
    function showError(){
        echo '<div class="ve-errortext" style="margin-bottom: 20px; width: 600px;">The Pixel ID you entered is invalid. Please provide a valid VitalEdge Pixel ID.
        You can login to your VitalEdge account to create or select an existing pixel
        and click the WordPress button to copy the VitalEdge Pixel ID.</div>';
    }
?>
