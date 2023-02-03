$('#string-length-input').on('input', function () {
    const input = $(this).val();
    $('#result').text('String length: ' + input.length);
});

$('#time-to-seconds-input').on('input', function () {
    const dateRegex = /(\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}:\d{2})/g;
    const input = $(this).val();
    const matches = input.match(dateRegex);
    const dates = [];
    let total = 0;
    let result = '';

    if (!matches) {
        $('#result').html('<span class="danger">No date time matches found</span>');
        return;
    }

    matches.sort();
    
    for (const match of matches) {     
        const dateString = match + '+0000';
        const date = new Date(dateString);

        if (isNaN(date)) {
            continue;
        }        

        dates.push(date);
    }

    // Fill missing dates
    for (const dateIdx in dates) {
        if (dateIdx < 1) {
            continue;
        }

        const prevDate = dates[dateIdx - 1];
        const currDate = dates[dateIdx];

        const mDiff = monthDiff(prevDate, currDate);
        console.log(mDiff);
        for (let i = 1; i <= mDiff; i++) {
            dates.push(addMonthsToDate(prevDate, i))
        }
    }

    dates.sort(function(a, b) {
        return a.getTime() - b.getTime();
    });
    
    console.log(dates);

    for (const dateIdx in dates) {

        const prevDate = dates[dateIdx - 1];
        const currDate = dates[dateIdx];

        if (dateIdx < 1) {
            continue;
        } else {
            diff = (currDate.getTime() - prevDate.getTime()) / 1000
            total += diff;            
        }

        const datePrevString = prevDate.toISOString().replace('T', ' ').replace('.000Z', '');
        const dateCurrString = currDate.toISOString().replace('T', ' ').replace('.000Z', '');

        const timeString = toHHMMSS(diff);
        
        result += '<strong>' + datePrevString + ' ➡️ ' + dateCurrString + ' = </strong>' + timeString + ' (' + diff + ' s., Σ: ' + total + ' s.)<br />';
    }

    $('#result').html(result);
});

function monthDiff(dateFrom, dateTo) {
    return dateTo.getMonth() - dateFrom.getMonth() + (12 * (dateTo.getFullYear() - dateFrom.getFullYear()));
}

function addMonthsToDate(date, months) {
    const newDate = new Date(date);

    newDate.setUTCDate(1);
    newDate.setUTCHours(0);
    newDate.setUTCMinutes(0);
    newDate.setUTCSeconds(0);
    newDate.setUTCMonth(date.getMonth() + months);
    
    console.log(newDate);
    return newDate;
}

function toHHMMSS(seconds) {
    var sec_num = parseInt(seconds, 10); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    return hours+':'+minutes+':'+seconds;
}