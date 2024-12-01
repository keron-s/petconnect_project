function deleteService(serviceId) {
    fetch('delete_service.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `service_id=${serviceId}`,
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        location.reload(); // Reload to reflect changes
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
