# Projeto usando_e_debugando_api

# Instruções:

Os atributos href das tag a do html estão definidos para funcionar no 

endereço: localhost/usando_a_api_da_empresa_stokki

Se o uso não for no caminho acima então será preciso mudar essa informação no href 

 nos arquivos da pasta templates 

# Funcionalidades:

Há uma automatização de require_once através da classe Autoload.

Há um sistema para debug de problemas.

É possível alterna entre o modo desenvolvimento e o modo de produção.

O modo de desenvolvimento usa os dados da api_teste que foi baseado no modo de produção.

O modo de produção usa os dados fornecidos pela documentação da API da empresa STOKKI.

Há um botão que armazena os dados da API no banco de dados.

Foi adicionado sistema de upload de xml.

# Detalhes do sistema:

Na pasta app/config é onde se define as configurações

do sistema (ERP) como token e conexão com o banco de dados.

Na pasta api_teste/config armazena as configurações da api_teste.

No index da api_teste se define a senha do token (authorization)

do cabeçalho http.

# Banco de dados

Foram utilizadas quatro tabelas

produto, pedidos, notasficais, arquivos.

As colunas pertencentes a elas são os response 

descritos na documentação.

O response series da Tabela 'notasficais' foi

usado como chave estrangeira se referindo a chave
 
primária da tabela pedidos.









