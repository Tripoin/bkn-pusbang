
<!DOCTYPE html>
<html>
    <head>
        <title><?=FRAMEWORK_TITLE;?> V<?=FRAMEWORK_VERSI;?>=> ERROR MESSAGE </title>
        <style>
            body{
                font-family: 'COURIER';
                background: #DEDEDE;
            }
            .headers {
                border-radius: 15px;
                background: #FF6830;
                color: white;
                
                padding: 5px; 
                /*height: 80px;*/ 
                width: 80%;
                text-align: left;
                font-size:30px;
            }
            .bodytext {
                border-radius: 15px;
                background: #999999;
                color: black;
                font-weight: bold;
                padding: 20px; 
                width: 97%;
                text-align: left;
                font-size:16px;
            }
        </style>
    </head>
    <body>
        <br/><br/><br/><br/>
        <div align="center">
            <div class="headers">
                <h2 style="font-weight: bold;padding: 15px;"><?=FRAMEWORK_TITLE;?> V<?=FRAMEWORK_VERSI;?> => ERROR MESSAGE</h2>
                <div class="bodytext">
                    <table width="100%">
                        <tr>
                            <td style="width:10%">FILE => </td>
                            <td style="width:90%;padding:10px;"><?=$file;?></td>
                        </tr>
                        <tr>
                            <td style="width:10%">LINE => </td>
                            <td style="width:90%;padding:10px;"><?=$line;?></td>
                        </tr>
                        <tr>
                            <td style="width:10%">MESSAGE => </td>
                            <td style="width:90%;padding:10px; word-wrap:break-word;"><?=$message;?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <br/>
            <?=TEXT_COPYRIGHT;?>
        </div>
    </body>
</html>
