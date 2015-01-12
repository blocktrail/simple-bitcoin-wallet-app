<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Please Send Me Bitcoin</h2>

		<div>
			<p>
			{{ ucfirst($payee_fname) }} {{ ucfirst($payee_lname) }} has requested you send bitcoin to the address <a href="https://www.blocktrail.com/BTC/address/{{ $address }}" target="_blank">{{ $address }}</a>.
			</p>
			
			@if($msg)
				<b>Message:</b>
				<br/>
				{{ $msg }}
			@endif
		</div>
	</body>
</html>
