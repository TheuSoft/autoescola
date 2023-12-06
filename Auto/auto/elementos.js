////// FORMATACAO CELULAR

function formatarCPF(campo) {
    var cpf = campo.value.replace(/\D/g, ''); // Remove todos os não dígitos
    cpf = cpf.slice(0, 11); // Limita o comprimento do CPF a 11 caracteres

    // Adiciona os pontos e o traço de acordo com o tamanho do CPF
    if (cpf.length > 9) {
        cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})/, '$1.$2.$3-');
    } else if (cpf.length > 6) {
        cpf = cpf.replace(/(\d{3})(\d{3})/, '$1.$2.');
    } else if (cpf.length > 3) {
        cpf = cpf.replace(/(\d{3})/, '$1.');
    }

    campo.value = cpf;
}

document.addEventListener('DOMContentLoaded', function() {
    var campoCPF = document.getElementById('cpf');
    if (campoCPF) {
        campoCPF.addEventListener('input', function(event) {
            formatarCPF(event.target);
        });
    }
});

/////FORMATACAO TELEFONE

function formatarTelefone(input) {
    // Remove todos os caracteres não numéricos do input
    let digits = input.value.replace(/\D/g, '');

    // Aplica a formatação esperada (**) *****-****
    let formatted = '';
    if (digits.length > 2) {
        formatted = '(' + digits.substring(0, 2) + ')';
        if (digits.length > 6) {
            formatted += ' ' + digits.substring(2, 7) + '-';
            formatted += digits.substring(7, 11);
        } else {
            formatted += ' ' + digits.substring(2);
        }
    } else {
        formatted = digits;
    }

    // Define o valor formatado no campo de input
    input.value = formatted;
}

/////// Deletar Alunos
function confirmDelete() {
    return confirm("Tem certeza de que deseja excluir este aluno?");
}
/// Deletar Carro
function confirmDeletecr() {
    return confirm("Tem certeza de que deseja excluir este carro?");
}
///// Cancelar Agendamento
function confirmDeleteag() {
    return confirm("Tem certeza de que deseja cancelar esta aula?");
}