# n8n Workflows for Resume Automation

This directory contains n8n workflow configurations for automating resume updates across various job platforms.

## Setup Instructions

### 1. Install n8n

```bash
# Install n8n globally
npm install -g n8n

# Or use Docker
docker run -it --rm --name n8n -p 5678:5678 -v ~/.n8n:/home/node/.n8n n8nio/n8n
```

### 2. Import Workflows

1. Start n8n: `n8n start`
2. Open n8n in your browser: `http://localhost:5678`
3. Import the workflow JSON files from this directory

### 3. Configure Environment Variables

Set these environment variables in your n8n instance:

```bash
# Laravel webhook URL
WEBHOOK_URL=http://your-laravel-app.com/webhooks/n8n/response

# LinkedIn credentials (encrypted)
LINKEDIN_USERNAME=your_linkedin_email
LINKEDIN_PASSWORD=your_linkedin_password

# Other platform credentials
NAUKRI_USERNAME=your_naukri_email
NAUKRI_PASSWORD=your_naukri_password
```

## Available Workflows

### LinkedIn Automation (`linkedin-automation.json`)

**Features:**
- Automatic login to LinkedIn
- Profile information update (headline, summary, location, website)
- Experience section update
- Skills section update
- Resume PDF upload

**Workflow Steps:**
1. Receives webhook from Laravel with resume data
2. Filters for LinkedIn platform requests
3. Prepares LinkedIn-specific data
4. Navigates to LinkedIn login page
5. Logs in with stored credentials
6. Updates profile information
7. Updates experience section
8. Updates skills section
9. Uploads resume PDF
10. Sends success/failure response back to Laravel

**Security Features:**
- Encrypted credential storage
- Error handling and logging
- Bot behavior simulation (delays, human-like interactions)
- Screenshot capture for debugging

## Platform Support

### Currently Implemented
- ✅ LinkedIn (Full automation)

### Planned Implementation
- 🔄 Naukri.com (Browser automation)
- 🔄 GulfTalent (Browser automation)
- 🔄 Indeed (Browser automation)

## Security Considerations

1. **Credential Storage**: All platform credentials are encrypted and stored securely
2. **Rate Limiting**: Built-in delays to avoid triggering anti-bot measures
3. **Error Handling**: Comprehensive error logging and user notifications
4. **Manual Fallback**: If automation fails, users are notified to update manually

## Troubleshooting

### Common Issues

1. **Login Failures**
   - Check if credentials are correct
   - Verify if 2FA is enabled (requires manual intervention)
   - Check for CAPTCHA challenges

2. **Element Not Found Errors**
   - LinkedIn may have updated their UI
   - Update selectors in the workflow
   - Check if the page loaded completely

3. **Rate Limiting**
   - Increase delays between actions
   - Use different IP addresses
   - Implement exponential backoff

### Debugging

1. **Enable Screenshots**: Set `screenshot: true` in Puppeteer nodes
2. **Check Logs**: Review bot_logs in the sync_logs table
3. **Test Manually**: Verify selectors work in browser dev tools

## Development

### Adding New Platforms

1. Create a new workflow JSON file
2. Implement platform-specific selectors and logic
3. Add credential handling
4. Test thoroughly with different resume formats
5. Update documentation

### Workflow Structure

Each workflow follows this pattern:
1. **Webhook Trigger**: Receives data from Laravel
2. **Platform Filter**: Routes to correct platform workflow
3. **Data Preparation**: Formats data for platform
4. **Authentication**: Logs into platform
5. **Data Update**: Updates profile/resume information
6. **Response**: Sends status back to Laravel

## Monitoring

### Success Metrics
- Sync completion rate
- Average execution time
- Error frequency by platform
- User satisfaction scores

### Alerts
- Failed sync attempts
- Authentication failures
- Platform UI changes
- High error rates

## Legal Compliance

- **Terms of Service**: Ensure compliance with each platform's ToS
- **Rate Limiting**: Respect platform rate limits
- **Data Privacy**: Handle user data according to privacy laws
- **User Consent**: Obtain explicit consent for automation

## Support

For issues or questions:
1. Check the troubleshooting section
2. Review n8n documentation
3. Check Laravel logs for webhook responses
4. Contact the development team
