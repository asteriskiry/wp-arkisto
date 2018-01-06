// Javascriptit pöytäkirjojen admin-sivuille

// Päivämäärän valitsin
jQuery(document).ready(function() {
    jQuery( '.datepicker'  ).datepicker();
    jQuery( '.datepicker'  ).datepicker( "option", "showAnim", "slideDown" );
});

// Pöytäkirjojen PDF-uploaderi

var addButton = document.getElementById( 'pdf-upload-button' );
var deleteButton = document.getElementById( 'pdf-delete-button' );
var pk = document.getElementById( 'pdf-tag' );
var hidden = document.getElementById( 'pdf-hidden-field' );
var pdfUploader = wp.media({
    title: 'Valitse pöytäkirja',
    button: { text: 'Käytä' },
    multiple: false,
    library: { order: 'ASC', orderby: 'title',  type: 'application/pdf'  }
});

addButton.addEventListener( 'click', function() {
    if ( pdfUploader ) {
        pdfUploader.open();
    }
} );
/*
customUploader.on( 'select', function() {
    var attachment = customUploader.state().get('selection').first().toJSON();
    img.setAttribute( 'src', attachment.url );
    hidden.setAttribute( 'value', JSON.stringify( [{ id: attachment.id, url: attachment.url }]) );
    toggleVisibility( 'ADD' );
} );

deleteButton.addEventListener( 'click', function() {
    img.removeAttribute( 'src' );
    hidden.removeAttribute( 'value' );
    toggleVisibility( 'DELETE' );
} );

var toggleVisibility = function( action ) {
    if ( 'ADD' === action ) {
        addButton.style.display = 'none';
        deleteButton.style.display = '';
        img.setAttribute( 'style', 'width: 100%;' );
    }

    if ( 'DELETE' === action ) {
        addButton.style.display = '';
        deleteButton.style.display = 'none';
        img.removeAttribute('style');
    }
};

window.addEventListener( 'DOMContentLoaded', function() {
    if ( "" === customUploads.imageData || 0 === customUploads.imageData.length ) {
        toggleVisibility( 'DELETE' );
    } else {
        img.setAttribute( 'src', customUploads.imageData.src );
        hidden.setAttribute( 'value', JSON.stringify([ customUploads.imageData ]) );
        toggleVisibility( 'ADD' );
    }
} );
*/
