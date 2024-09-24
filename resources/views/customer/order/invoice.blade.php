<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .invoice-container {
            padding: 20px;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background-color: #f7f7f7;
        }

        h1,
        h2,
        h3,
        h4 {
            margin: 0;
            padding: 0;
        }

        .header,
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: #fff;
        }

        .header h1 {
            font-size: 24px;
        }

        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
        }

        .invoice-details div {
            width: 48%;
        }

        .invoice-details h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .invoice-details p {
            margin: 0;
            padding: 2px 0;
        }

        .invoice-items {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 20px;
        }

        .invoice-items table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-items th,
        .invoice-items td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .invoice-items th {
            background-color: #f5f5f5;
        }

        .invoice-summary {
            text-align: right;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
        }

        .invoice-summary p {
            margin: 5px 0;
            font-size: 16px;
        }

        .footer {
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="invoice-container">
        <!-- Invoice Header -->
        <div class="header">
            <h1>Invoice</h1>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <div>
                <h2>Billing Information</h2>
                <p><strong>Customer Name:</strong> {{ $user->name }} </p>
                <p><strong>Address:</strong> {{ $transactions[0]->delivery_address }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
            </div>

            <div>
                <h2>Invoice Information</h2>
                <p><strong>Invoice #:</strong> {{ $invoice_number }}</p>
                <p><strong>Date:</strong>
                    {{ \Carbon\Carbon::parse($transactions[0]->delivery_date)->format('d M Y H:i') }}
                </p>
                <p><strong>Due Date:</strong>
                    {{ \Carbon\Carbon::parse($transactions[0]->delivery_date)->subDays(1)->format('d M Y H:i') }}</p>
            </div>
        </div>

        <!-- Invoice Items -->
        <div class="invoice-items">
            <h2>Items</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Merchant</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $index => $t)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $menus[$index]->name }}</td>
                            <td>{{ $merchants[$index]->name }}</td>
                            <td>{{ $t->quantity }}</td>
                            <td>Rp {{ number_format($menus[$index]->price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Invoice Summary -->
        <div class="invoice-summary">
            <p><strong>Subtotal:</strong>Rp {{ number_format($transactions[0]->total_price_transaction, 0, ',', '.') }}
            </p>
        </div>

        <!-- Invoice Footer -->
        <div class="footer">
            <p>Thank you for your business!</p>
            <p>If you have any questions, feel free to contact us at supportmarketplacekatering@gmail.com</p>
        </div>
    </div>

</body>

</html>
