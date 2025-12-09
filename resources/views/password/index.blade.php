<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Generator</title>
    <style>
        body {
            font-family: Georgia, 'Times New Roman', serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px;
            background: #fff;
        }

        .options-box {
            border: 1px solid #000;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .options-box legend {
            padding: 0 5px;
            font-size: 14px;
        }

        .options-box input[type="number"] {
            width: 50px;
            text-align: center;
            margin-bottom: 10px;
        }

        .options-box label {
            display: block;
            margin: 5px 0;
            font-size: 14px;
        }

        .generate-btn {
            background: #d4d0c8;
            border: 2px outset #fff;
            padding: 15px 50px;
            font-size: 20px;
            font-family: Georgia, 'Times New Roman', serif;
            cursor: pointer;
            margin-bottom: 40px;
        }

        .generate-btn:active {
            border-style: inset;
        }

        .password-display {
            font-size: 48px;
            font-weight: bold;
            font-family: Georgia, 'Times New Roman', serif;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .success-message {
            font-size: 14px;
            color: #333;
        }
    </style>
</head>
<body><h2>A Simple Password Generator</h2>
    <form action="/" method="POST">
        @csrf
        <fieldset class="options-box">
            <legend>Password details</legend>
            <label>Lenght of the password<label>
            <input type="number" name="length" value="{{ $length ?? 8 }}" min="1" max="128">
            <label>
                <input type="checkbox" name="numbers" {{ ($numbers ?? true) ? 'checked' : '' }}> Numbers
            </label>
            <label>
                <input type="checkbox" name="big_letters" {{ ($big_letters ?? true) ? 'checked' : '' }}> Big letters
            </label>
            <label>
                <input type="checkbox" name="small_letters" {{ ($small_letters ?? true) ? 'checked' : '' }}> Small letters
            </label>
        </fieldset>

        <button type="submit" class="generate-btn">Generate</button>
    </form>

    @isset($password)
        <div class="password-display">{{ $password }}</div>
        <div class="success-message">Password generated!</div>
    @endisset
</body>
</html>

