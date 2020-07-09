const objets = document.getElementById('user_data');
if (objets) {
    objets.addEventListener('click',e =>{
        if (e.target.className === "btn btn-danger btn-circle btn-sm") {
            if (confirm('Êtes-vous sûr de vouloir supprimer ?')) {
                const id = e.target.getAttribute('data-id');
                fetch(`/building/delete/${id}`,{
                    method: 'DELETE',
                }).then(res => window.location.reload());
            }
        }
    });
}

// Room
const rooms = document.getElementById('room');
if (rooms) {
    rooms.addEventListener('click',e =>{
        if (e.target.className === "btn btn-danger btn-circle btn-sm") {
            if (confirm('Êtes-vous sûr de vouloir supprimer ?')) {
                const id = e.target.getAttribute('data-id');
                fetch(`/room/delete/${id}`,{
                    method: 'DELETE',
                }).then(res => window.location.reload());
            }
        }
    });
}