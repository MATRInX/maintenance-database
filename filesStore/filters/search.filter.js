(function () {
    'use strict';

    angular
        .module('customFilter')
        .filter('search', searchFilter);

    searchFilter.$inject = ['$filter', '$log'];

    function searchFilter($filter, $log) {
        return search;

        function search(data, searchItems, atributes) {
            var firstFiltered = data;
            var filtered = [];
            var wordArray = [];
            $log.log(atributes);
            
            if (searchItems !== '') {
                var reg = new String(searchItems);
                var regexp = new RegExp(reg, "i");
                // petla po reordach
                for (var i = 0; i < firstFiltered.length; i++) {
                    // petla po wlasciwosciach
                    for (var j = 0; j < atributes.length; j++) {
                        // sprawdzam dane pole
                        var tempstr = new String(firstFiltered[i][atributes[j]]);
                        if (tempstr.search(regexp) >= 0) {
                            // pasuje
                            var isUnique = true;
                            for (var k = 0; k < filtered.length; k++) {
                                if (filtered[k] === firstFiltered[i][atributes[j]]) {
                                    isUnique = false;
                                    break;
                                }
                            }
                            if (isUnique) {
                                filtered.push(firstFiltered[i][atributes[j]]);
                                break;
                            }
                        }
                    }
                }
                filtered.sort();
                return filtered;
                //var isDivider1 = searchItems.search(";");
                //var isDivider2 = searchItems.search(",");
                //var isDivider3 = searchItems.search("/");
                //var isDivider4 = searchItems.search("|");
                //if (isDivider1 >= 0) {
                //    wordArray = searchItems.split(";");
                //}
                //else {
                //    if (isDivider2 >= 0) {
                //        wordArray = searchItems.split(",");
                //    }
                //    else {
                //        if (isDivider3 >= 0) {
                //            wordArray = searchItems.split("/");
                //        }
                //        else {
                //            if (isDivider4 >= 0) {
                //                wordArray = searchItems.split("|");
                //            }
                //            else {
                //                wordArray[0] = searchItems;
                //            }                            
                //        }                        
                //    }                    
                //}
                //for (var j = 0; j < wordArray.length; j++) {
                //    var reg = new String(wordArray[j]);
                //    var regexp = new RegExp(reg, "i");
                //    if (filtered.length > 0) {
                //        firstFiltered = filtered;
                //        filtered = [];
                //    }
                //    for (var i = 0; i < firstFiltered.length; i++) {
                //        var item;
                //        for (item in firstFiltered[i]) {
                //            var tempstr = new String(firstFiltered[i][item]);
                //            if (tempstr.search(regexp) >= 0) {
                //                var isUnique = true;
                //                for (var k = 0; k < filtered.length; k++) {
                //                    if (filtered[k] === firstFiltered[i][item]) {
                //                        isUnique = false;
                //                        break;
                //                    }
                //                }
                //                if (isUnique) {
                //                    filtered.push(firstFiltered[i][item]);
                //                    break;
                //                }                                
                                
                //            }
                //        }
                //    }
                //}
                //return filtered;
            }
            else {
                return data;
            }
        }
    }
})();