![NovaCode](assets/videos/preview.gif)

<style>
        /* Стили для центрирования и оформления формы регистрации */
        .auth-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 80px); /* Вычитаем высоту хедера */
            padding: 20px;
        }
        
        .auth-card {
            background-color: var(--gray-800);
            border: 1px solid var(--gray-700);
            border-radius: 12px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.8);
        }

        .auth-card h2 {
            margin-top: 0;
            margin-bottom: 30px;
            text-align: center;
            color: var(--neon-cyan);
            font-family: 'Black Han Sans', sans-serif;
            font-size: 32px;
        }

        .form-group {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            color: var(--text-secondary);
            font-size: 14px;
        }

        .form-group input {
            background-color: var(--bg-color);
            border: 1px solid var(--gray-700);
            color: var(--text-primary);
            padding: 14px;
            border-radius: 6px;
            font-family: inherit;
            font-size: 16px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--neon-cyan);
            box-shadow: 0 0 8px var(--neon-cyan-dim);
        }

        .btn-auth {
            background-color: var(--text-primary);
            color: var(--bg-color);
            border: none;
            padding: 14px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: opacity 0.2s;
            margin-top: 10px;
        }

        .btn-auth:hover {
            opacity: 0.9;
        }

        .auth-error {
            background-color: rgba(255, 0, 0, 0.1);
            border: 1px solid red;
            color: #ff6b6b;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }

        .auth-links {
            margin-top: 25px;
            text-align: center;
            font-size: 14px;
            color: var(--text-secondary);
        }

        .auth-links a {
            color: var(--neon-cyan);
            text-decoration: none;
        }

        .auth-links a:hover {
            text-decoration: underline;
        }
    </style>