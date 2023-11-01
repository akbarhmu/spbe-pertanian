CREATE TABLE
    `mst_desa` (
        `id_kec` int(15) UNSIGNED NOT NULL,
        `id_desa` bigint(20) UNSIGNED NOT NULL,
        `nm_desa` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
        PRIMARY KEY (`id_desa`) USING BTREE
    ) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'master desa' ROW_FORMAT = Compact;