// Client-side validation script
//
// ******************************************
//     REQUIRED FIELDS
// ******************************************
// this function checks all fields with class="required" and makes sure they are not blank
// to use this:
//     (1) add class="required" to each form element you want to be required
//     (2) add onsubmit="return checkRequired();" to the form tag
var displayError = '';
function checkRequired() {
    if (document.getElementById('submit_button')) {
        document.getElementById('submit_button').value = 'Please Wait...';
        document.getElementById('submit_button').disabled = true;
    }
    var formFields = getElementsByClassName(document,'required');
    var displayError = '';
    for (var t=0;t<formFields.length;t++) {
        if (formFields[t].type == 'text') {
                if (formFields[t].value.length < 1) {
                    displayError = displayError + formFields[t].title + " is required.\n";
                    formFields[t].style.backgroundColor = '#FFCED6';
                } else {
                    formFields[t].style.backgroundColor = 'white';
                }
        } else if (formFields[t].type == 'checkbox') {
                if (formFields[t].checked == false) {
                    displayError = displayError + formFields[t].title + " is required.\n";
                    formFields[t].parentNode.style.backgroundColor = '#FFCED6';
                } else {
                    formFields[t].style.backgroundColor = 'white';
                }
        } else if (formFields[t].type == 'radio') {
            var radioFields = getElementsByName(document,formFields[t].name);
            var radioCount = 0;
            for (var c=0;c<radioFields.length;c++) {
                if (radioFields[c].checked == true || radioCount > 0) {
                    radioCount++;
                }
            }
            if (radioCount == 0) {
                displayError = displayError + formFields[t].title + " is required.\n";
                formFields[t].parentNode.parentNode.parentNode.style.backgroundColor = '#FFCED6';
            } else {
                formFields[t].parentNode.parentNode.parentNode.style.backgroundColor = 'white';
            }
        } else if (formFields[t].type == 'select-one') {
                if (formFields[t].selectedIndex == 0) {
                    displayError = displayError + formFields[t].title + " is required.\n";
                    formFields[t].style.backgroundColor = '#FFCED6';
                } else {
                    formFields[t].style.backgroundColor = 'white';
                }
        }
    }
    if (displayError !== '') {
        if (document.getElementById('submit_button')) {
            document.getElementById('submit_button').disabled = false;
            document.getElementById('submit_button').value = ' Submit ';
        }
        window.alert(displayError);
        return false;
    }
}

// ******************************************
//     SINGLE FIELD VALIDATION
// ******************************************

// use to require a valid email address (looks for _@_._) in a form element
// add onblur="validateEmail(this);" to the form element 
function validateEmail(node) {
    node.style.backgroundColor = 'white';
    var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (node.value.length > 0) {
        if (filter.test(node.value)) {
            displayError = "";
        } else {
            displayError = "A valid e-mail address is required.\n";
            node.style.backgroundColor = '#FFCED6';
        }
    }
    if (displayError !== '') {
        window.alert(displayError);
        return false;
    }
}
// use to allow only numeric characters with a minimum, maximum, and/or exact number of digits in a form element
// add onblur="formatAlpha(this,x,y,z);" to the form element where (you can use more than one):
//    x is the minimum number of digits required (0 to ignore)
//    y is the maximum number of digits required (0 to ignore)
//    z is the exact number of digits required (0 to ignore)
function validateNumber(node,minLength,maxLength,exactLength) {
    node.style.backgroundColor = 'white';
    displayError = "";
    removeSpecialChars(node);
    removeAlphas(node);
    if (minLength > 0) {
        if (node.value.length < minLength) {
            displayError = node.title + " must be at least " + minLength + " digits.\n";
            node.style.backgroundColor = '#FFCED6';
        }
    }
    if (maxLength > 0) {
        if (node.value.length > maxLength) {
            displayError = node.title + " cannot be longer than " + maxLength + " digits.\n";
            node.style.backgroundColor = '#FFCED6';
        }
    }
    if (exactLength > 0) {
        if (node.value.length !== exactLength) {
            displayError = node.title + " must be exactly " + exactLength + " digits.\n";
            node.style.backgroundColor = '#FFCED6';
        }
    }
    if (displayError !== '') {
        window.alert(displayError);
        return false;
    }
}

// use to allow only numeric/decimal characters with a minimum, maximum, and/or exact number of digits in a form element
// add onblur="formatAlpha(this,x,y,z);" to the form element where (you can use more than one):
//    x is the minimum number of digits required (0 to ignore)
//    y is the maximum number of digits required (0 to ignore)
//    z is the exact number of digits required (0 to ignore)
function validateDecNumber(node,minLength,maxLength,exactLength) {
    node.style.backgroundColor = 'white';
    displayError = "";
    removeNonPeriodSpecial(node);
    removeAlphas(node);
    if (minLength > 0) {
        if (node.value.length < minLength) {
            displayError = node.title + " must be at least " + minLength + " digits.\n";
            node.style.backgroundColor = '#FFCED6';
        }
    }
    if (maxLength > 0) {
        if (node.value.length > maxLength) {
            displayError = node.title + " cannot be longer than " + maxLength + " digits.\n";
            node.style.backgroundColor = '#FFCED6';
        }
    }
    if (exactLength > 0) {
        if (node.value.length !== exactLength) {
            displayError = node.title + " must be exactly " + exactLength + " digits.\n";
            node.style.backgroundColor = '#FFCED6';
        }
    }
    if (node.value.indexOf('.') != node.value.lastIndexOf('.')) {
            displayError = node.title + " must have exactly one decimal point.\n";
            node.style.backgroundColor = '#FFCED6';
    }
    if (displayError !== '') {
        window.alert(displayError);
        return false;
    }
}

// use to format a 9-digit social security number in 000-00-0000 format in a form element
// add onblur="validateSSN(this);" to the form element 
function validateSSN(node) {
    node.style.backgroundColor = 'white';
    displayError = "";
    if (node.value !== '') {
        removeSpecialChars(node);
        removeAlphas(node);
        if (node.value.length > 0) {
            node.value = node.value.substr(0,3) + '-' + node.value.substr(3,2) + '-' + node.value.substr(5,4);
            if (node.value.length !== 11) {
                displayError = "A valid Social Security Number is required.\n";
                node.style.backgroundColor = '#FFCED6';
            }
        }
    }
    if (displayError !== '') {
        window.alert(displayError);
        return false;
    }
}

// ******************************************
//     FIELD FORMATTING
// ******************************************
// use to allow only alphabetic characters in a form element
// add onblur="formatAlpha(this);" to the form element 
function formatAlpha(node) {
    removeSpecialChars(node);
    removeNums(node);
}
// use to allow only numeric characters in a form element
// add onblur="formatAlpha(this);" to the form element 
function formatNumber(node) {
    removeSpecialChars(node);
    removeAlphas(node);
}
// use to format a 5-digit numeric ZIP code in a form element
// add onblur="formatZip(this);" to the form element 
function formatZip(node) {
    node.style.backgroundColor = 'white';
    if (node.value !== '') {
        removeSpecialChars(node);
        removeAlphas(node);
        if (node.value.length > 0) {
            node.value = node.value.substr(0,5);
            if (node.value.length !== 5) {
                node.style.backgroundColor = '#FFCED6';
                return false
            }
        }
    }
}
// use to format a 10-digit phone number in 000-000-0000 format in a form element
// add onblur="formatPhoneNum(this);" to the form element 
function formatPhoneNum(node) {
    node.style.backgroundColor = 'white';
    if (node.value !== '') {
        removeSpecialChars(node);
        removeAlphas(node);
        if (node.value.length > 0) {
            if (node.value.length > 10) {
                if (node.value.substr(0,1) == '1') {
                    node.value = node.value.substr(1,10);
                    node.value = node.value.substr(0,3) + '-' + node.value.substr(3,3) + '-' + node.value.substr(6,4);
                    if (node.value.length !== 12) {
                        node.style.backgroundColor = '#FFCED6';
                        return false
                    }
                } else {
                    node.style.backgroundColor = '#FFCED6';
                    return false
                }
            } else {
                node.value = node.value.substr(0,3) + '-' + node.value.substr(3,3) + '-' + node.value.substr(6,4);
                if (node.value.length !== 12) {
                    node.style.backgroundColor = '#FFCED6';
                    return false
                }
            }
        }
    }
}
// used to remove placeholder text when user clicks on a form element
// add onfocus="removePlaceholder(this,'Whatever placeholder text you have');" to the form element
// for best results, form element should have a style of color:#666666 so the placeholder
//  text is gray until user selects the field
function removePlaceholder(node,strPlaceholder) {
    if (node.value == strPlaceholder) {
        node.value = '';
        node.style.color = 'black';
    }
}
// used to add placeholder text when user clicks away from a form element without adding text
// add onblur="addPlaceholder(this,'Whatever placeholder text you have');" to the form element
function addPlaceholder(node,strPlaceholder) {
    if (node.value == '') {
        node.value = strPlaceholder;
        node.style.color = '#666';
    }
}

// ******************************************
//     BEHIND THE SCENES
// ******************************************
// the following functions are used by the above functions and are not applied directly 

// gets all elements in a page that have a specified class
function getElementsByClassName(node, classname)
{
    var a = [];
    var re = new RegExp('\\b' + classname + '\\b');
    var els = node.getElementsByTagName("*");
    for(var i=0,j=els.length; i<j; i++)
        if(re.test(els[i].className))a.push(els[i]);
    return a;
}
function getElementsByName(node, classname)
{
    var a = [];
    var re = new RegExp('\\b' + classname + '\\b');
    var els = node.getElementsByTagName("*");
    for(var i=0,j=els.length; i<j; i++)
        if(re.test(els[i].name))a.push(els[i]);
    return a;
}
// removes non alpha-numeric characters
function removeSpecialChars(node) {
     node.value=filterSpecial(node.value);

     function filterSpecial(str) {
          re = /\ |$|,|@|#|~|`|\%|\*|\^|\&|\(|\)|\+|\=|\[|\-|\_|\]|\[|\}|\{|\;|\:|\'|\"|\<|\>|\?|\||\\|\!|\$|\./g;
          return str.replace(re, "");
     }
}
// removes non alpha-numeric characters
function removeNonPeriodSpecial(node) {
     node.value=filterSpecial(node.value);

     function filterSpecial(str) {
          re = /\ |$|,|@|#|~|`|\%|\*|\^|\&|\(|\)|\+|\=|\[|\-|\_|\]|\[|\}|\{|\;|\:|\'|\"|\<|\>|\?|\||\\|\!|\$/g;
          return str.replace(re, "");
     }
}

// removes alphabetic characters
function removeAlphas(node) {
     node.value=filterAlpha(node.value);

     function filterAlpha(str) {
          re = /\$|a|b|c|d|e|f|g|h|i|j|k|l|m|n|o|p|q|r|s|t|u|v|w|x|y|z|A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z|/g;
          return str.replace(re, "");
     }
}

// removes numeric characters
function removeNums(node) {
     node.value=filterNum(node.value);

     function filterNum(str) {
          re = /\$|0|1|2|3|4|5|6|7|8|9|/g;
          return str.replace(re, "");
     }
}