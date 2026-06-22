
var morethanoneelectorate = "Parts of your postcode fall in more than one electorate. Please choose your electorate from the following list";
var pmnotfound = 'Sorry, a Candidate could not be found for that postcode. Please try again.';
var notsurewhichelectorate = '<p>Not sure which electorate is yours? Use your suburb and postcode to <a href="http://apps.aec.gov.au/esearch/" target="_blank"><u>find your electorate here.</u></a></p>';


// -----------------------------------------------------------------------------

jQuery(document).ready( function() 
{
        form_init();
     
        // event handler for change to postcode
        jQuery('#postcode').keyup(function(e)
        {
                if(jQuery('#postcode').val().length === 4)
                {                    
                    jQuery('.multimember').hide();
                    emc_get_federal_member_by_postcode(jQuery(this).val());
                }
        });
        
        // disable paste as it causes multiple calls
        jQuery('#postcode').bind("cut copy paste",function(e) {
            e.preventDefault();
        });

        // disable enter key
        jQuery('#EmailForm').keypress(function(e){
           if (e.keyCode === 10 || e.keyCode === 13) {
               e.preventDefault();
           }
        });

        // allow "Enter" key in the message textbox
        jQuery('#messagetext').bind('keypress', function(e) {
            e.stopPropagation(); 
        });

        jQuery('#EmailForm #firstname, #EmailForm #senderemail, #EmailForm #surname, #EmailForm #postcode, #EmailForm #subjecttext, #EmailForm #messagetext').on('input propertychange ', function(){ //propoertychange for IE<9
            enable_form1_send_button();
        });

        jQuery('#ReferForm input[name="orig_email"], #ReferForm input[name="orig_full_name"], #ReferForm input[name="dest_email"]').on('input', function(){
            enable_form2_send_button();
        });


}); // document.ready END




// ------------------------------ Functions ---------------------------------- //

function form_init()
{    
        jQuery('#EmailForm #Send').attr('disabled','disabled').css('color', '#999');
        jQuery('#ReferForm #Send').attr('disabled','disabled').css('color', '#999');         
}

function emc_get_federal_member_by_postcode(postcode) 
{    
    displayWaitingMessage();

    jQuery.getJSON(
        'https://www.essentialdata.com.au/v2ajax/getfederalmembersvotesbypostcode?jsoncallback=?',
        {
            "postcode" : postcode,
            "house" : 'LOWER',
            "campaign": jQuery('#hiddenCampaignId').val()
        }, 
        function (data) 
        {
            console.log(data);
            
            jQuery('.multimember').empty();
            
            var lastid = '';
            var elid = []; elid[0] = '';
            var elname = []; var nrel = 0;
            jQuery.each(data, function (i, item) 
            {                
                if(item.electorateId !== lastid) {
                    lastid = item.electorateId;
                    elid[nrel] = item.electorateId;
                    elname[nrel] = item.electorateName;
                    nrel++;
                }
            });
            
            // creating electorate holders based on how many distinct ones we have
            if (nrel === 0) {
                jQuery('<div id="electorateHolder">'+pmnotfound+'</div>').appendTo('.multimember').slideDown();
            }
            else if (nrel === 1) {
                jQuery('<div id="polliechoicecontainer"></div>').appendTo('.multimember');
                jQuery('<ul id="candidates-list"></ul>').appendTo('#polliechoicecontainer');
                jQuery('<li id="electorate-candidate-holder-'+lastid+'"><label class="electoratelabel">Electorate: ' + elname[0] + '</label></li>').appendTo('#candidates-list');
                jQuery('<div id="candidates-wrapper-'+lastid+'" class="candidates-wrapper"></div>').appendTo('#electorate-candidate-holder-'+lastid);
                jQuery('<input type="hidden" value="'+lastid+'" name="ElectorateID" id="hiddenElectorateID" />').appendTo('#candidates-list');
            }
            else if (nrel > 1)
            {
                jQuery('<div id="polliechoicecontainer"></div>').appendTo('.multimember');
                jQuery('<div id="polliechoiceintro" class="instructionpanel"><h4>' + morethanoneelectorate + '</h4></div>').appendTo('#polliechoicecontainer');                                
                jQuery('<ul id="choosepollie" class="radiochoice"></ul>').appendTo('#polliechoicecontainer');

                jQuery.each(elid, function (i, item) 
                {  
                    jQuery('<li id="electorate-candidate-holder-'+item+'"><input type="radio" class="radios" name="ElectorateID" value="' + item + '"><label class="electoratelabel">Electorate: ' + 
                            elname[i] + '</label></li>').appendTo('#choosepollie');
                    jQuery('<div id="candidates-wrapper-'+item+'" class="candidates-wrapper"></div>').appendTo('#electorate-candidate-holder-'+item).hide();
                });
                
                jQuery('.radiochoice input.radios').on('click', function() {
                    jQuery('#polliechoicecontainer').find('.candidates-wrapper').hide();
                    jQuery(this).parent('li').find('.candidates-wrapper').show();
                    enable_form1_send_button();
                });
                
                jQuery(notsurewhichelectorate).appendTo('#polliechoicecontainer');
            }                
            
            // dislaying/adding candidates to the placeholders
            var itemvote;
            var itemphoto;
            
            jQuery.each(data, function (i, item) 
            {
                if(item.vote === null) {
                    itemvote = 'Undecided';
                } else {
                    itemvote = item.vote;
                }
                jQuery('<div id="candidate-wrapper-'+item.candidateId+'" class="candidate-result"></div>').appendTo('#candidates-wrapper-'+item.electorateId);
                if(item.photo !== '') {
                    itemphoto = '<img style="height: 100px; " src="https://essentialdata.com.au' + item.photo + '" alt="' + item.firstname + ' ' + item.surname + '" />';
                } else {
                    itemphoto = '<div class="empty-image-placeholder"></div>';
                }
                var candidatevote;
                if(itemvote.toLowerCase() === 'for') { candidatevote = 'Supportive'; }
                else if(itemvote.toLowerCase() === 'against') { candidatevote = 'Unsupportive'; }
                else { candidatevote = 'Undecided'; }
                jQuery('<div class="candidate-image">'+itemphoto+'</div>').appendTo('#candidate-wrapper-'+item.candidateId);
                jQuery('<div class="candidate-vote '+ candidatevote.toLowerCase() +'">'+candidatevote+'</div>').appendTo('#candidate-wrapper-'+item.candidateId);
                jQuery('<div class="candidate-details">'+ item.firstname + ' ' + item.surname + ', ' + item.party + '</div>').appendTo('#candidate-wrapper-'+item.candidateId);
                jQuery('.electorateName').slideDown();                    
            });

            
            enable_form1_send_button();
            
            jQuery('.multimember').slideDown('slow');
        }
    );
    return false;
}

function displayWaitingMessage()
{
        jQuery('.multimember').empty();
        
        jQuery('<div id="waitingMessage">Getting Electorate info, please wait</div>')
            .css({'margin-top' : '20px', 'padding' : '20px 0'})
            .appendTo('.multimember');
    
        jQuery('.multimember').slideDown('slow');
}


function enable_form1_send_button() 
{
    var multiTrue = true;
    
    if(jQuery('#choosepollie').length > 0) {
        if(!(jQuery('input[name="ElectorateID"]:checked').val() > 0)) {
            multiTrue = false;
        }
    } else {
        if(!(jQuery('input[name="ElectorateID"]').val() > 0)) {
            multiTrue = false;
        }
    }
    
    if ((jQuery.trim(jQuery('#EmailForm #firstname').val()) !== "")
        && (jQuery.trim(jQuery('#EmailForm #senderemail').val()) !== "")
        && (jQuery.trim(jQuery('#EmailForm #surname').val()) !== "")
        && (jQuery.trim(jQuery('#EmailForm #postcode').val()) !== "") && multiTrue
    ) {
        jQuery('#EmailForm #Send').removeAttr('disabled').css('color', '#333');
    } else {
        jQuery('#EmailForm #Send').attr('disabled','disabled').css('color', '#999');
    }
}
