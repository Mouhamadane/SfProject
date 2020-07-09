$(document).ready(function(){
    var bourse =  $('#student_typeStudent').val();
    $('#student_numRoom').hide('slow');
    $('#student_adresse').hide('slow');
    $('#student_bourse').hide('slow');
    $('#student_typeStudent').change(function(){
        bourse =  $('#student_typeStudent').val();
        if (bourse === "NB") {
            $('#student_adresse').show('slow');
            $('#student_numRoom').hide('slow');
            $('#student_bourse').hide('slow');

        }else if(bourse === "BNL"){
            $('#student_adresse').show('slow');
            $('#student_bourse').show('slow');
            $('#student_numRoom').hide('slow');
        }

        else {
            $('#student_adresse').hide('slow');
            $('#student_numRoom').show('slow');
            $('#student_bourse').show('slow');
        }
 
    });
});