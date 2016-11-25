#!/bin/bash
### ThanhDD 2016-11-04

ENV=development

echo "Reading config...." >&2
source ./config/$ENV.cfg

#SYNC_LOGS=/var/www/cbm-server/storage/logs/sync-logs/$ENV-$(date +%Y%m%d).log

# Append logs
append_logs() {  echo $@ >> $SYNC_LOGS; }

# Sync Data
# rsync -auz -e"ssh -i ./civicbm_id_rsa" cbm@210.211.102.93:/var/www/html/shared/cbm/ ./data
sync_campaign_data() {
	append_logs "----- Begin sync campaign data from $SSH_CIVI_IP to LOCAL: $(date +%T) -----"
	/usr/bin/rsync $RSYNC_OPTS -e "ssh -i $SSH_KEY" $SSH_ACCOUNT@$SSH_CIVI_IP:$SYNC_REMOTE_DIR $SYNC_LOCAL_DIR >> $SYNC_TMP_LOGS
	grep -v "uptodate$" $SYNC_TMP_LOGS >> $SYNC_LOGS && /bin/rm $SYNC_TMP_LOGS
  	# grep -v "uptodate$" $SYNC_TMP_LOGS >> $SYNC_LOGS
  	append_logs "----- sync done: $(date +%T)"
}

# SCP file from Dev Servers
sync_campaign_data

exit 0