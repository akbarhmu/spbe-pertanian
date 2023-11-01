CREATE TABLE
    `mst_kec` (
        `id_kab` int(6) NOT NULL,
        `id_kec` int(15) UNSIGNED NOT NULL,
        `nm_kec` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
        `id` int(10) NOT NULL AUTO_INCREMENT,
        `lat` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
        `lon` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
        PRIMARY KEY (`id`, `id_kec`, `id_kab`) USING BTREE
    ) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'Master Kecamatan' ROW_FORMAT = Compact;