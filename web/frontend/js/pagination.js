/*
 ******* www.devandclick.fr *******

 modeles :
 1 : suivant,precedent
 2 : pagination
 3 : pagination + suivant,precedent
 
 @nbParPage : nombre d'elements par page
 @divSelect : elements a paginer
 @divPager : nom du div ou s'insere la pagination
 @model : Modeles de pagination voir ci-dessus
 */
function pagination(nbParPage,divSelect,divPager,model)
{	
    //Initialisation
    var nbElem = $(divSelect).length;
    var nbPage = Math.ceil(nbElem / nbParPage);
    var pageLoad = 1;
    
    $(divSelect).each(function(index) {
        if (index < nbParPage)
            $(divSelect).eq(index).show();
        else
            $(divSelect).eq(index).hide();
    });
    
    //Reset & verification
    function reset() {
        if (nbPage < 2) $(divPager).hide();
        if (pageLoad == nbPage) $(divPager + ' span.suivant').hide(); else $(divPager + ' span.suivant').show();
        if (pageLoad == 1) $(divPager + ' span.precedent').hide(); else $(divPager + ' span.precedent').show();
        $(divPager + ' ul li').removeClass('selected');
        $(divPager + ' ul li').eq(pageLoad -1).addClass('selected');
    }
    
    //Pagination generation
    if (model != 1) {
        $(divPager).html('<ul class="pagination pagination-custom"></ul>');
        for(i = 1; i <= nbPage; i++) $(divPager + ' ul').append('<li class="page-item"><a class="page-link"> ' + i + '</a></li>');
    
        //Changement click page
        $(divPager + ' ul.pagination.pagination-custom li.page-item').click(function() {
            if ($(this).index() + 1 != pageLoad) {
                pageLoad = $(this).index() + 1;
                $(divSelect).hide();
                
                $(divSelect).each(function(i) {
                    if (i >= ((pageLoad * nbParPage) - nbParPage) && i < (pageLoad * nbParPage)) $(this).show();
                });
                
                reset();
            }
        });
    }
    
    //Suivant Precedent
    if (model == 1) {
        $(divPager).prepend('<span class="precedent">Precedent</span>');
        $(divPager).append('<span class="suivant">Suivant></span>');
    } else if (model == 3) {
        $(divPager + ' ul').before('');
        $(divPager + ' ul').after('');
    }
	
	//Evenement click sur suivant
    $(divPager + ' span.suivant').click(function() {
        if (pageLoad < nbPage) {
            pageLoad += 1;
            $(divSelect).hide();
            
            $(divSelect).each(function(i) {
                if (i >= ((pageLoad * nbParPage) - nbParPage) && i < (pageLoad * nbParPage)) $(this).show();
            });
            
            reset();
        }
    });
	
	//Evenement click sur precedent
    $(divPager + ' span.precedent').click(function() {
        if (pageLoad -1 >= 1) {
            pageLoad -= 1;
            $(divSelect).hide();
            
            $(divSelect).each(function(i) {
                if (i >= ((pageLoad * nbParPage) - nbParPage) && i < (pageLoad * nbParPage)) $(this).show();
            });
            
            reset();
        }
    });
    
    reset();
}