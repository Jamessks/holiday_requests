<?php

use Http\instance\UserInstance;
?>
</div>
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
<script src="/assets/app.bundle.js"></script>
<?php if (UserInstance::rbacPerms('manage_notifications')): ?>
    <script src="/assets/roleBasedNotifications.bundle.js"></script>
<?php endif; ?>

</body>

</html>