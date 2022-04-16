$("#products").change(function (e) {
    e.preventDefault();
    var x = $(this).val()
    if (x.trim().length) {
        if (Object.keys(a).includes(x)) {
            if (a[x].length == 0) {
                console.log("no variants")
                $(".varient").empty()
            }
            else {
                var m = ``
                var ctr = 0
                a[x].forEach(i => {
                    m += `
                    <option value="${ctr}">
                    `
                    i.forEach(j => {
                        console.log(Object.keys(j)[0], j[Object.keys(j)[0]])
                        m += Object.keys(j)[0] + " : " + j[Object.keys(j)[0]]
                    })
                    m += `</option > `
                    ctr++
                });
                addVarient(m)
            }
        }
    }
    else {
        $(".varient").empty()
    }
});

function addVarient(data) {
    var m = `
    <label for="variant_name">
        <p class="mt-2">Choose Variant</p>
        <select name="varient" class=" w-full rounded-md border-gray-200 shadow-sm" id="products">
            ${data}
        </select>
    </label>
    `
    $(".varient").html(m)
}

$(".custom").click(function (e) {
    e.preventDefault();
    $(".date").toggleClass("hidden");
    $(this).toggleClass("bg-blue-200")
});

// handle status buttons
$(".paid").click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/ajax/getByStatus",
        data: { status: "paid" },
        success: function (response) {
            var resp = JSON.parse(response)
            console.log(resp)
            renderTable(resp)
        }
    });
});
$(".processing").click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/ajax/getByStatus",
        data: { status: "processing" },
        success: function (response) {
            var resp = JSON.parse(response)
            console.log(resp)
            renderTable(resp)
        }
    });
});
$(".dispatched").click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/ajax/getByStatus",
        data: { status: "dispatched" },
        success: function (response) {
            var resp = JSON.parse(response)
            console.log(resp)
            renderTable(resp)
        }
    });
});
$(".shipped").click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/ajax/getByStatus",
        data: { status: "shipped" },
        success: function (response) {
            var resp = JSON.parse(response)
            console.log(resp)
            renderTable(resp)
        }
    });
});
$(".refunded").click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/ajax/getByStatus",
        data: { status: "refunded" },
        success: function (response) {
            var resp = JSON.parse(response)
            console.log(resp)
            renderTable(resp)
        }
    });
});
//search by date
$(".today").click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/ajax/getToday",
        data: { action: "today" },
        success: function (response) {
            var resp = JSON.parse(response)
            console.log(resp)
            renderTable(resp)
        }
    });
});
$(".this_week").click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/ajax/getThisWeek",
        data: { action: "today" },
        success: function (response) {
            var resp = JSON.parse(response)
            console.log(resp)
            renderTable(resp)
        }
    });
});
$(".this_month").click(function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "/ajax/getThisMonth",
        data: { action: "today" },
        success: function (response) {
            var resp = JSON.parse(response)
            console.log(resp)
            renderTable(resp)
        }
    });
});
$(".searchCustom").click(function (e) {
    e.preventDefault();
    var to = $('.to_date').val().trim()
    var from = $('.from_date').val().trim()
    console.log(to, from)
    if (is_date(to) && is_date(from)) {
        console.log("date valid")
        $.ajax({
            type: "POST",
            url: "/ajax/getCustom",
            data: { action: "custom", to: to, from: from },
            success: function (response) {
                var resp = JSON.parse(response)
                console.log(resp)
                renderTable(resp)
            }
        });
    }
    else {
        alert("to or from dates are invalid eg : format(dd-mm-Y)")
    }
});

// handle dd change
$("body").on("change", '.status', function (e) {
    e.preventDefault();
    var status = $(this).val().trim()
    var id = $(this).attr("data").trim()
    if (status == '' && id == '') {
        alert("invalid data")
    }
    else {
        $.ajax({
            type: "POST",
            url: "/ajax/changeStatus",
            data: { action: "status", status: status, id: id },
            success: function (response) {
                var resp = JSON.parse(response)
                console.log(resp)
                alert("changed")
                renderTable(resp)
            }
        });
    }
});
function renderTable(data) {
    var m = `
    `
    data.forEach(i => {
        m += `
        <tr class="text-center">
                    <td class="p-3 border">${i["customer name"]}</td>
                    <td class="p-3 border">${i["quantity"]}</td>
                    <td class="p-3 border">${i["productId"]["$oid"]}</td>
                    <td class="p-3 border">${i["varient"]}</td>
                    <td class="p-3 border">
                        <select class="rounded-lg shadow-md border-gray-200 status" data="${i["_id"]}" name="status" id="">
                            <option value="paid" ${i.status == "paid" ? "selected" : ""}>paid</option>
                            <option value="processing" ${i.status == "processing" ? "selected" : ""}>processing</option>
                            <option value="dispatched" ${i.status == "dispatched" ? "selected" : ""}>dispatched</option>
                            <option value="shipped" ${i.status == "shipped" ? "selected" : ""}>shipped</option>
                            <option value="refunded" ${i.status == "refunded" ? "selected" : ""}>refunded</option>
                        </select>
                    </td>
                    <td class="p-3 border">${i["order date"]["$date"]["$numberLong"]}</td>
                </tr>
        `
    });

    $(".tbody").html(m)
}

function is_date(date) {
    var date_regex = /^(0[1-9]|1\d|2\d|3[01])-(0[1-9]|1[0-2])-(19|20)\d{2}$/;
    if (!(date_regex.test(date))) {
        return false;
    }
    return true
}