/**
 * PDF-uploaderin js:t
 **/

var addButton = document.getElementById( 'pk-upload-button' );
var deleteButton = document.getElementById( 'pk-delete-button' );
var img = document.getElementById( 'pk-tag' );
var hidden = document.getElementById( 'pk-hidden' );
var pkUploader = wp.media({
    title: 'Valitse pöytäkirja',
    button: { text: 'Valitse' },
    multiple: false,
    library: { order: 'ASC', orderby: 'date', type: 'application/pdf' }
});

addButton.addEventListener( 'click', function() {
    if ( pkUploader ) {
        pkUploader.open();
    }
} );

pkUploader.on( 'select', function() {
    var attachment = pkUploader.state().get('selection').first().toJSON();
    img.setAttribute( 'src', attachment.sizes.medium.url );
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
    if ( "" === pkUploads.pkdata || 0 === pkUploads.pkdata.length ) {
        toggleVisibility( 'DELETE' );
    } else {
        img.setAttribute( 'src', pkUploads.pkdata.src );
        hidden.setAttribute( 'value', JSON.stringify([ pkUploads.pkdata ]) );
        toggleVisibility( 'ADD' );
    }
} );
