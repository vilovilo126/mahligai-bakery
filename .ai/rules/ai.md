---
paths:
  - 'app/Services/Ai/**'
---

# Ai

## Use variables before heredoc, not concat inside
GeminiService::buildPrompt uses a nowdoc/heredoc prompt. Don't put '.config(...).' concatenation literal inside the heredoc body — it renders literally. Assign the value to a PHP variable ($whatsapp = config('business.whatsapp_display')) before the heredoc and interpolate $whatsapp instead.
