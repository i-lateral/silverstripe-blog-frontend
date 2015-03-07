<ul>
	<% if PostLink %><li>
        <a href="$PostLink">
            <%t BlogFrontEnd.NewBlogPost 'New Blog Post' %>
        </a>
    </li><% end_if %> 
	
    <% if CommentLink %><li>
        <a href="$CommentLink">$CommentText</a>
    </li><% end_if %>
	
    <li>
        <a href="Security/logout"><%t BlogFrontEnd.Logout 'Logout' %></a>
    </li>
</ul>
