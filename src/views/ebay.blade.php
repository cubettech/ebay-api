<html>
    <head>
        
        <title>Ebay Package</title>
        
        <style tyle="text/css">
            h1,h3{
                font-weight: normal;
                margin: 0;
            }
            .item{
                background-color: #fbfbfb;
                margin-bottom: 5px;
                padding: 10px;
                border: 2px solid #ddd;
                position: relative;
                line-height: 22px;
            }
            .sl_no{
                position: absolute;
                top: 0;
                right: 0;
                padding: 3px;
                background: #eddada;
                font-weight: bold;
                font-size: 11px;
            }
            a{
                color:#4288CE;
                text-decoration: none;
            }
            a:hover{
                text-decoration: underline;
            }
            .form{
                padding: 20px;
                width: 400px;
                background:#fbfbfb;
                margin-bottom: 10px;
                border-radius: 5px;
                border:5px solid #ccc;
                float: left;
            }
            input[type=text]{
                float: right;
            }
            .right{
                float: left;
                margin-left: 20px;
                padding: 20px;
            }
            select{
                float: right;
            }
            .green{
                font-size: 15px;
                font-weight: bold;
                color: green;
            }
        </style>
    </head>
    <body>

        <INPUT TYPE="button" NAME=AUTHORIZE VALUE="Ebay - Sign In"
               onclick="window.open('https://signin.sandbox.ebay.com/ws/eBayISAPI.dll?SignIn&runame=<?php echo $runame; ?>&SessID=<?php echo $sessionId; ?>','','width=1000,height=600,scrollbars=yes')" />
        <br />
        <br />
        
        <div class="form">
        
        {{ Form::open(array('name'=>'ebayForm','url' => 'getebay','method'=>'post')) }}

        <h1>Ebay</h1>

        <p>
            {{ $errors->first('email') }}
            {{ $errors->first('password') }}
        </p>

        <p>
            {{ Form::label('StartTimeFrom', 'StartTimeFrom' ) }}
            {{ Form::text('StartTimeFrom', $formInput['StartTimeFrom']) }}
        </p>

        <p>
            {{ Form::label('StartTimeTo', 'StartTimeTo') }}
            {{ Form::text('StartTimeTo', $formInput['StartTimeTo']) }}
        </p>

        <p>
            {{ Form::label('EntriesPerPage', 'EntriesPerPage') }}
            {{ Form::text('EntriesPerPage', $formInput['EntriesPerPage']) }}
        </p>
        
       
        <?php $startCount = 1 ; if($sellerList && array_key_exists('HasMoreItems',$sellerList) ): ?>
            
        <p>
            {{ Form::label('Page Number', 'Page Number') }}
            
            <?php 
            $totalPages = $sellerList['PaginationResult']['TotalNumberOfPages'] ;
            $selArray = array();
            
            for($i=$startCount;$i<=$totalPages; $i++){
                $selArray[$i] = $i ;
                if($formInput['pageNumber']==$i)
                    $sel = $i ;
            }
            
            $startCount = ($sel-1)*$formInput['EntriesPerPage'] + 1 ;
            ?>
            
            {{ Form::select('pageNumber', $selArray , $sel) }}
        </p>

        <?php endif; ?>


        <p>{{ Form::submit('Submit!',array('name'=>'sellerListSubmit')) }}</p>

        {{ Form::close() }}
        
        </div>
        
        <div class="right">
            
        <?php if($getUser): ?>    
            
            <?php $user = $getUser['User']; ?>
        
            User ID : <span class="green"> <?php echo $user['UserID']; ?></span>
            <br />
            <br />
            
            Email : <span class="green"> <?php echo $user['Email']; ?></span>
            <br />
            <br />
            
            Registration Date : <span class="green"> <?php echo $user['RegistrationDate']; ?></span>
            <br />
            <br />
       
        <?php else: ?>
            
            Please login to continue.
            
        <?php endif; ?>

        <?php if ($tokenStatus != ""): ?>
            Token Status : <span class="green"> <?php echo $tokenStatus; ?></span>
            <br />
            <br />
        <?php endif; ?>
            
        </div>     


        <div style="clear:both;"></div>
        
        
        
    <?php if ($sellerList): ?>

    <h3>Sellers List</h3>

        <?php if ($sellerList['Ack'] == 'Success'): ?>

            <?php 
                //if there are only one element in array assign it to an array
                if(!array_key_exists(0,$sellerList['ItemArray']['Item'])){
                    $sellerList['ItemArray']['Item'] = array($sellerList['ItemArray']['Item']) ;
                }
            ?>
                <?php $i=$startCount; foreach ($sellerList['ItemArray']['Item'] as $key => $item): ?>
                    
                    <div class="item"> 
                        <div class="sl_no"><?php echo $i ; ?></div>
                        Id : <?=$item['ItemID']?><br />
                        Title : <?=$item['Title'];?> <br />
                        Category : <?=$item['PrimaryCategory']['CategoryName']?><br />
                        View Url : <a href="<?=$item['ListingDetails']['ViewItemURL']?>" target="_blank"><?=$item['ListingDetails']['ViewItemURL']?></a> <br />
                    </div>

                <?php $i++ ; endforeach; ?>

        <?php else : ?>

            <?php echo $sellerList['Errors']['LongMessage'] ; ?>

        <?php endif; ?>     

    <?php endif; ?>     

    <br />
    <br />


        
        
    <?php if ($myeBaySelling): ?>
        
    <h3>My eBay Selling</h3>

    <?php if ($myeBaySelling['Ack'] == 'Success'): ?>
    
             <?php if(array_key_exists('ActiveList',$myeBaySelling)): ?>
            
                <?php 
                   //if there are only one element in array assign it to an array
                   if(!array_key_exists(0,$myeBaySelling['ActiveList']['ItemArray']['Item'])){
                       $myeBaySelling['ActiveList']['ItemArray']['Item'] = array($myeBaySelling['ActiveList']['ItemArray']['Item']) ;
                   }
                ?>
                    
               <?php $i=$startCount; foreach ($myeBaySelling['ActiveList']['ItemArray']['Item'] as $key => $item): ?>
                    
                   <div class="item">
                        <div class="sl_no"><?php echo $i ; ?></div>
                        Id : <?=$item['ItemID']?><br />
                        Title : <?=$item['Title'];?> <br />
                        View Url : <a href="<?=$item['ListingDetails']['ViewItemURL']?>" target="_blank"><?=$item['ListingDetails']['ViewItemURL']?></a> <br />
                   </div>
    
               <?php $i++ ; endforeach; ?>
                
            <?php endif ; ?>    

    <?php else : ?>         

        <?php echo $myeBaySelling['Errors']['LongMessage'] ; ?>

    <?php endif ; ?>
                    
    <?php endif ; ?>                    

    <?php echo $error == '' ? '' : $error; ?>

</body>
</html>
