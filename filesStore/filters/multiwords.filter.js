(function () {
    'use strict';

    angular
        .module('customFilter')
        .filter('multiwords', multiwordsFilter);

    multiwordsFilter.$inject = ['$filter', '$log'];

    function multiwordsFilter($filter, $log) {
        return multiwords;

        function multiwords(data, searchItems) {
            var firstFiltered = data;
            var filtered = [];
            var wordArray = [];

            
            if (searchItems !== '') {
                var isDivider1 = searchItems.search(";");
                var isDivider2 = searchItems.search(",");
                var isDivider3 = searchItems.search("/");
                var isDivider4 = searchItems.search("|");
                if (isDivider1 >= 0) {
                    wordArray = searchItems.split(";");
                }
                else {
                    if (isDivider2 >= 0) {
                        wordArray = searchItems.split(",");
                    }
                    else {
                        if (isDivider3 >= 0) {
                            wordArray = searchItems.split("/");
                        }
                        else {
                            if (isDivider4 >= 0) {
                                wordArray = searchItems.split("|");
                            }
                            else {
                                wordArray[0] = searchItems;
                            }                            
                        }                        
                    }                    
                }
                for (var j = 0; j < wordArray.length; j++) {
                    var reg = new String(wordArray[j]);
                    var regexp = new RegExp(reg, "i");
                    if (filtered.length > 0) {
                        firstFiltered = filtered;
                        filtered = [];
                    }
                    for (var i = 0; i < firstFiltered.length; i++) {
                        var item;
                        for (item in firstFiltered[i]) {
                            var tempstr = new String(firstFiltered[i][item]);
                            if (tempstr.search(regexp) >= 0) {
                                filtered.push(firstFiltered[i]);
                                break;
                            }
                        }
                    }
                }
                return filtered;
            }
            else {
                return data;
            }
        }
    }
})();