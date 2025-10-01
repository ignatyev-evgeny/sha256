```markdown
# SHA256 Hash Generator API

Простой PHP API для генерации SHA256 хешей из текста и JSON данных.

## Описание

Скрипт предоставляет REST API для:
- Генерации SHA256 хеша из текстовой строки
- Обработки JSON объектов: фильтрации полей первого уровня, сортировки и генерации хеша

## Требования

- PHP 7.0 или выше
- Веб-сервер (Apache, Nginx и т.д.)

## Установка

1. Клонируйте репозиторий или скачайте файлы
2. Разместите файлы на веб-сервере
3. Убедитесь, что `index.php` доступен через HTTP

## Использование

### 1. Хеширование текста

**Запрос:**
```bash
curl -X POST http://your-domain.com/index.php \
  -H "Content-Type: application/json" \
  -d '{"text": "Ваша строка"}'
```

**Ответ:**
```json
{
  "original": "Ваша строка",
  "sha256": "a592c3e3d5e3d2e3f7e8..."
}
```

### 2. Обработка JSON

Скрипт фильтрует только поля первого уровня (без вложенных массивов), сортирует их по алфавиту и создает хеш.

**Запрос:**
```bash
curl -X POST http://your-domain.com/index.php \
  -H "Content-Type: application/json" \
  -d '{
    "json": {
      "TerminalKey": "1758526459892DEMO",
      "Amount": 100,
      "OrderId": "16",
      "Token": "fd212d12f179d02290630571dcce01852eb1442f493690021f3c73b6f5a6e9f3",
      "Description": "Попробуйте тариф",
      "DATA": {
        "nested": "value"
      },
      "Receipt": {
        "Email": "test@mail.ru"
      }
    }
  }'
```

**Ответ:**
```json
{
  "concat": "100Попробуйте тариф16fd212...1758526459892DEMO",
  "sha256": "b8e5a2f4c9d3e1a7f6b5...",
  "original": { ... }
}
```

## Логика обработки JSON

1. Извлекаются только поля первого уровня (без вложенных объектов/массивов)
2. Поля сортируются по ключу в алфавитном порядке
3. Значения конкатенируются в одну строку
4. Генерируется SHA256 хеш от полученной строки

## Примеры

### JavaScript (Fetch API)

```javascript
// Хеширование текста
fetch('http://your-domain.com/index.php', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({ text: 'Hello World' })
})
  .then(res => res.json())
  .then(data => console.log(data.sha256));

// Обработка JSON
fetch('http://your-domain.com/index.php', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    json: {
      Name: 'John',
      Age: 30,
      City: 'Moscow'
    }
  })
})
  .then(res => res.json())
  .then(data => console.log(data));
```

### Python

```python
import requests
import json

# Хеширование текста
response = requests.post(
    'http://your-domain.com/index.php',
    json={'text': 'Hello World'}
)
print(response.json())

# Обработка JSON
response = requests.post(
    'http://your-domain.com/index.php',
    json={
        'json': {
            'Name': 'John',
            'Age': 30,
            'City': 'Moscow'
        }
    }
)
print(response.json())
```

## Структура проекта

```
.
├── .gitignore
├── index.php      # Основной файл API
└── README.md      # Документация
```

## Обработка ошибок

При использовании GET запроса вместо POST:
```json
{
  "error": "Используйте POST запрос"
}
```

## Безопасность

⚠️ **Внимание**: Данный скрипт предназначен для демонстрационных целей. Для production использования рекомендуется:
- Добавить валидацию входных данных
- Ограничить размер принимаемых данных
- Настроить CORS политику
- Добавить rate limiting
- Использовать HTTPS