## API teste ExitLag

API de assinatura mensal de plano em Laravel desenvolvida para avaliação.
Algumas etapas foram automatizadas para facilitar o processo de assinatura.

Segue abaixo links para testes e documentação da API:

- [Documentação API](https://documenter.getpostman.com/view/4557888/TzRYbiqE).
- [https://exitlag.meuprojeto.digital/api](https://exitlag.meuprojeto.digital/api).

Foi integrado o Braintree SDK.

Antes de iniciar o projeto localmente, execute um comando seed para criar o gateway padrão no banco de dados.

No .env.exemple já tem as chaves sandbox da minha conta de teste.


No front foi utilizado Vue, Vuex (Para tratar das rotas), Vue i18n para gerar as traduções e utilizei também o método fetch para puxar as questões e respostas da pesquisa de satisfação.

A pesquisa de satisfação consiste em um relacionamento de duas tabelas e foi utilizado o método Eloquent para filtrar os resultados na requisição.
