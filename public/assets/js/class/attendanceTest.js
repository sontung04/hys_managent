$(document).ready(function () {
    console.log(11222);
    $('.btnViewStudyClass').on('click', function () {
        $('#modalStudyInfo').modal('show');
    });

    $('.btnFeedbackCoach').on('click', function () {
        $('#modalFeedbackCoach').modal('show');
    });

    $('.btnAttenUpdate').on('click', function () {
        $('#modalAttenStudent').modal('show');
    });

    $('#testBtnEdit').on('click', function () {
        console.log('testBtnEdit');
        document.getElementById('care_staffQuestionRow').innerHTML = `<input type="text" name="question" id="question" class="form-control">`;
        document.getElementById('care_staffCommentRow').innerHTML = `<input type="text" name="comment" id="comment" class="form-control">`;
        $('#care_staffBtnSave').removeAttr('hidden');
        $('#testBtnEdit').attr('hidden', 'hidden');
    })
});
